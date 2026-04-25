<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BonDeCommande;
use Yajra\DataTables\Facades\DataTables;

class BonDeCommandeDatatableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BonDeCommande::select('bon_de_commandes.*')->with(['client', 'articles.article']);

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $data->whereBetween('date', [$request->start_date, $request->end_date]);
            }



            // Fetch $paiements once to pass down to action button components
            // This prevents an N+1 query problem while meeting view requirements
            $paiements = \App\Models\Paiement::select('id', 'methode')->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->setRowAttr([
                    'data-id' => function ($row) {
                        return $row->id;
                    }
                ])
                ->editColumn('num', function ($row) {
                    return $row->num;
                })
                ->addColumn('client_nom', function ($row) {
                    return $row->client->nom ?? '';
                })
                ->addColumn('client_ice', function ($row) {
                    return $row->client->ice ?? '';
                })
                ->addColumn('client_tel', function ($row) {
                    return $row->client->tel ?? '';
                })
                ->editColumn('montant', function ($row) {
                    return number_format($row->montant, 2, '.', '');
                })
                ->editColumn('date', function ($row) {
                    return date_format(date_create($row->date), 'd/m/Y');
                })

                ->addColumn('action', function ($row) use ($paiements) {
                    // This generates the actions column HTML programmatically for server-side
                    $actions = '';
                    if (auth()->user()->can('show one bon_commande') || auth()->user()->can('delete bon_commande') || auth()->user()->can('update bon_commande')  || auth()->user()->can('imprimer bon_commande')) {
                        // Render the corresponding livewire component correctly.
                        $actions = view('livewire.bon-commande-component', ['bon_commande_id' => $row->id, 'bon_commande' => $row, 'paiements' => $paiements])->render();
                    }
                    return $actions;
                })

                // Allow search on formatted date and relationships
                ->filterColumn('date', function($query, $keyword) {
                    $sql = "DATE_FORMAT(date, '%d/%m/%Y')  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('client_nom', function($query, $keyword) {
                    $query->whereHas('client', function($q) use($keyword) {
                        $q->where('nom', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('client_nom', function($query, $order) {
                    $query->join('clients', 'bon_de_commandes.client_id', '=', 'clients.id')
                          ->orderBy('clients.nom', $order);
                })
                ->orderColumn('client_ice', function($query, $order) {
                    $query->join('clients', 'bon_de_commandes.client_id', '=', 'clients.id')
                          ->orderBy('clients.ice', $order);
                })
                ->orderColumn('client_tel', function($query, $order) {
                    $query->join('clients', 'bon_de_commandes.client_id', '=', 'clients.id')
                          ->orderBy('clients.tel', $order);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
