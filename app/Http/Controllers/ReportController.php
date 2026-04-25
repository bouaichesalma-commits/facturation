<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $year = $request->get('year', date('Y')); 

    $factures = Facture::whereYear('date', $year)
    ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(montant) as total')
    ->groupBy('month')
    ->pluck('total', 'month');

    $devis = Devis::whereYear('date', $year)
        ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(montant) as total')
        ->groupBy('month')
        ->pluck('total', 'month');


    $monthlyData = [];
    for ($month = 1; $month <= 12; $month++) {
        $monthKey = sprintf('%04d-%02d', $year, $month);
        $monthlyData[] = [
            'month' => $monthKey,
            'amount' => ($factures[$monthKey] ?? 0) + ($devis[$monthKey] ?? 0),
        ];
    }

    $totalAmount = array_sum(array_column($monthlyData, 'amount'));

    return view('reports.index', [
        'year' => $year,
        'monthlyData' => $monthlyData,
        'totalAmount' => $totalAmount,
    ]);
}


}
