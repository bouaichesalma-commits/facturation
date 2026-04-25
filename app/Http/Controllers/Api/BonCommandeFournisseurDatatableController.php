<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BonCommandeFournisseurDatatableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = \App\Models\BonCommandeFournisseur::select('bon_commande_fournisseurs.*')->with(['fournisseur', 'articles.article']);

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $data->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($row) {
                        return $row->id;
                    }
                ])
                ->editColumn('num', function ($row) {
                    return $row->num;
                })
                ->addColumn('fournisseur_nom', function ($row) {
                    return $row->fournisseur->nom ?? '';
                })
                ->addColumn('fournisseur_ice', function ($row) {
                    return $row->fournisseur->ice ?? '';
                })
                ->addColumn('fournisseur_tel', function ($row) {
                    return $row->fournisseur->telephone ?? '';
                })
                ->editColumn('montant', function ($row) {
                    return number_format($row->montant, 2, '.', '');
                })
                ->editColumn('date', function ($row) {
                    return date_format(date_create($row->date), 'd/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $actions = '<div class="row"><div class="col-md-auto" style="margin-bottom: 10px;">';
                    
                    if (auth()->user()->can('show one bon_commande')) {
                        $actions .= '<button type="button" class="btn btn-info btn-voir" data-id="' . $row->id . '" title="Voir" style="padding: 3px 9px; font-size: 15px;"><i class="fas fa-eye"></i></button> ';
                    }

                    if (auth()->user()->can('update bon_commande')) {
                        $actions .= '<div class="d-inline-block"><a href="' . route("bon_commande_fournisseur.edit", $row->id) . '" class="btn btn-warning" title="Éditer" style="padding: 3px 9px; font-size: 16px;"><i class="fas fa-edit"></i></a></div> ';
                    }
                    
                    if (auth()->user()->can('create bon_commande')) {
                        $actions .= '<div class="d-inline-block">';
                        $actions .= '<form id="duplicateForm' . $row->id . '" action="' . route("bon_commande_fournisseur.duplicate", $row->id) . '" method="POST" class="d-inline">';
                        $actions .= csrf_field();
                        $actions .= '<a href="#" class="btn btn-dark" title="Dupliquer" style="padding: 3px 9px; font-size: 16px;" onclick="event.preventDefault(); document.getElementById(\'duplicateForm' . $row->id . '\').submit();"><i class="fas fa-copy"></i></a>';
                        $actions .= '</form></div> ';
                    }
                    
                    if (auth()->user()->can('delete bon_commande')) {
                        $actions .= '<div class="d-inline-block">';
                        $actions .= '<form action="' . route("bon_commande_fournisseur.destroy", $row->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce bon ?\');">';
                        $actions .= csrf_field() . method_field("DELETE");
                        $actions .= '<button type="submit" class="btn btn-danger" title="Supprimer" style="padding: 3px 9px; font-size: 16px;"><i class="fas fa-trash"></i></button>';
                        $actions .= '</form></div> ';
                    }
                    
                    if (auth()->user()->can('imprimer bon_commande')) {
                        $actions .= '<div class="d-inline-block"><a href="' . route("bon_commande_fournisseur.download", $row->id) . '" target="_blank" class="btn btn-success" title="Télécharger" style="padding: 3px 9px; font-size: 17px;"><i class="fas fa-file-alt"></i></a></div> ';
                    }
                    
                    $actions .= '</div></div>';
                    return $actions;
                })
                ->filterColumn('date', function($query, $keyword) {
                    $sql = "DATE_FORMAT(date, '%d/%m/%Y')  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('fournisseur_nom', function($query, $keyword) {
                    $query->whereHas('fournisseur', function($q) use($keyword) {
                        $q->where('nom', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('fournisseur_nom', function($query, $order) {
                    $query->join('fournisseurs', 'bon_commande_fournisseurs.fournisseur_id', '=', 'fournisseurs.id')
                          ->orderBy('fournisseurs.nom', $order);
                })
                ->orderColumn('fournisseur_ice', function($query, $order) {
                    $query->join('fournisseurs', 'bon_commande_fournisseurs.fournisseur_id', '=', 'fournisseurs.id')
                          ->orderBy('fournisseurs.ice', $order);
                })
                ->orderColumn('fournisseur_tel', function($query, $order) {
                    $query->join('fournisseurs', 'bon_commande_fournisseurs.fournisseur_id', '=', 'fournisseurs.id')
                          ->orderBy('fournisseurs.telephone', $order);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
