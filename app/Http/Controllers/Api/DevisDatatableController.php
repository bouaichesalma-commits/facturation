<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devis;
use Yajra\DataTables\Facades\DataTables;

class DevisDatatableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Devis::select('devis.*')->with(['client', 'articles', 'customArticles']);

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $data->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            if ($request->filled('etat') && $request->etat !== 'all') {
                $data->where('etat', $request->etat);
            }

            // Fetch $paiements once to pass down to action button components
            // This prevents an N+1 query problem while meeting view requirements
            $paiements = \App\Models\Paiement::select('id', 'methode')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowClass(function ($row) {
                    return $row->etat == 1 ? 'table-success' : '';
                })
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
                ->editColumn('nom_commercial', function ($row) {
                    return $row->nom_commercial;
                })
                ->addColumn('action', function ($row) use ($paiements) {
                    // This generates the actions column HTML programmatically for server-side
                    $actions = '';
                    if (auth()->user()->can('show one devis') || auth()->user()->can('delete devis') || auth()->user()->can('update devis') || auth()->user()->can('convert devis') || auth()->user()->can('imprimer devis')) {
                        // Render the corresponding livewire component correctly. We return raw HTML placeholder string to inject Livewire. 
                        // Note: DataTables + Livewire doesn't work perfectly perfectly out of the box because DataTables recreates DOM.
                        // However, we can use simple links here instead of livewire component for just actions to ensure it renders blazing fast.
                        $actions = view('livewire.devis-component', ['devis_id' => $row->id, 'devis' => $row, 'paiements' => $paiements])->render();
                    }
                    return $actions;
                })
                ->addColumn('checkbox_etat', function ($row) {
                    $isChecked = $row->etat == 1 ? 'checked' : '';
                    $html = '<div class="form-check form-switch p-0 justify-content-center">';
                    $html .= '<input class="form-check-input devis-checkbox mx-auto" type="checkbox" ' . $isChecked . '>';
                    $html .= '</div>';
                    return $html;
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
                    $query->join('clients', 'devis.client_id', '=', 'clients.id')
                          ->orderBy('clients.nom', $order);
                })
                ->orderColumn('client_ice', function($query, $order) {
                    $query->join('clients', 'devis.client_id', '=', 'clients.id')
                          ->orderBy('clients.ice', $order);
                })
                ->orderColumn('client_tel', function($query, $order) {
                    $query->join('clients', 'devis.client_id', '=', 'clients.id')
                          ->orderBy('clients.tel', $order);
                })
                ->rawColumns(['action', 'checkbox_etat'])
                ->make(true);
        }
    }
}
