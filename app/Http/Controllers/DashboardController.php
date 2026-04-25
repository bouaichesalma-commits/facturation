<?php

namespace App\Http\Controllers;

use App\Mail\sendNotificationMail;
use App\Models\Article;
use Carbon\Carbon;
use App\Models\Devis;
use App\Models\Client;
use App\Models\Facture;
use App\Notifications\SendSMS;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client as RestClient;

class DashboardController extends Controller
{
    

    public function index(Request $request)
    {
        $total_clients = Client::all()->count();
        $total_articles = Article::all()->count();

        $total_factures = Facture::all()->count();
        $paid_factures = Facture::all()->where('etat',1)->count();
        $unpaid_factures = Facture::all()->where('etat',0)->count();

        $total_devis = Devis::all()->count();
        $valid_devis = Devis::all()->where('etat',1)->count();
        $invalid_devis = Devis::all()->where('etat',0)->count();

        $start_date = $request->input('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $end_date = $request->input('end_date', Carbon::now()->endOfYear()->format('Y-m-d'));

        $new_clients = DB::table('clients')->whereBetween('created_at', [$start_date, $end_date . ' 23:59:59'])->count();
        $new_articles = DB::table('articles')->whereBetween('created_at', [$start_date, $end_date . ' 23:59:59'])->count();
        
        // --- Monthly Statistics for Current Period ---
        $start = Carbon::parse($start_date)->startOfMonth();
        $end = Carbon::parse($end_date)->startOfMonth();
        
        $monthsList = [];
        $caByMonth = [];
        $devisByMonth = [];
        $facturesByMonth = [];
        $clientsByMonth = [];
        
        $frenchMonths = ['01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril', '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'];

        $current = $start->copy();
        // Limit to 24 months max to display to avoid huge charts
        $monthsCount = 0;
        while ($current <= $end && $monthsCount < 24) {
            $key = $current->format('Y-m');
            $monthsList[] = $frenchMonths[$current->format('m')] . ' ' . $current->format('Y');
            $caByMonth[$key] = 0;
            $devisByMonth[$key] = 0;
            $facturesByMonth[$key] = 0;
            $clientsByMonth[$key] = 0;
            $current->addMonth();
            $monthsCount++;
        }

        // Devis by month
        $devisData = DB::table('devis')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month_key, COUNT(*) as count')
            ->whereBetween('date', [$start_date, $end_date . ' 23:59:59'])
            ->groupBy('month_key')
            ->get();
        foreach ($devisData as $data) {
            if (isset($devisByMonth[$data->month_key])) {
                $devisByMonth[$data->month_key] = $data->count;
            }
        }

        // Factures by month
        $facturesData = DB::table('factures')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month_key, COUNT(*) as count')
            ->whereBetween('date', [$start_date, $end_date . ' 23:59:59'])
            ->groupBy('month_key')
            ->get();
        foreach ($facturesData as $data) {
            if (isset($facturesByMonth[$data->month_key])) {
                $facturesByMonth[$data->month_key] = $data->count;
            }
        }

        // Chiffre d'Affaires (CA) Total Encaissé + Non-encaissé by month
        $caData = DB::table('factures')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month_key, SUM(montant) as total')
            ->whereBetween('date', [$start_date, $end_date . ' 23:59:59'])
            ->groupBy('month_key')
            ->get();
        foreach ($caData as $data) {
            if (isset($caByMonth[$data->month_key])) {
                $caByMonth[$data->month_key] = (float)$data->total;
            }
        }

        // New clients by month
        $clientsData = DB::table('clients')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month_key, COUNT(*) as count')
            ->whereBetween('created_at', [$start_date, $end_date . ' 23:59:59'])
            ->groupBy('month_key')
            ->get();
        foreach ($clientsData as $data) {
            if (isset($clientsByMonth[$data->month_key])) {
                $clientsByMonth[$data->month_key] = $data->count;
            }
        }

        // Total Chiffre d'Affaires for the entire selected period
        $total_ca_periode = DB::table('factures')
            ->whereBetween('date', [$start_date, $end_date . ' 23:59:59'])
            ->sum('montant');

        return view('dashboard',compact(
            'total_clients','total_articles','total_factures','total_devis',
            'paid_factures','unpaid_factures','valid_devis','invalid_devis',
            'new_clients','new_articles',
            'devisByMonth', 'facturesByMonth', 'caByMonth', 'clientsByMonth', 'start_date', 'end_date', 'monthsList', 'total_ca_periode'
        ));
    }
}
