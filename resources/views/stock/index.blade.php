@extends('layouts.app')

@section('content')

<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading">Stocks</h1>
    <div class="p-2 justify-content-end">
        <a class="btn btn-primary me-3" href="{{ route('categorieproduits.index') }}">
            <i class="bi bi-grid"></i> Catégorie Produit
        </a>
        <a class="btn btn-primary me-3" href="{{ route('marques.index') }}">
            <i class="bi bi-grid"></i> Marque
        </a>
        <a class="btn btn-primary me-3" href="{{ route('fournisseurs.index') }}">
            <i class="bi bi-grid"></i> Fournisseur
        </a>
        <a class="pull-right btn btn-primary me-2" href="{{ route('stock.create') }}">
            Ajouter un produit <i class="bi bi-plus-lg"></i>
        </a>
    </div>
</div>

{{-- Capital Calculation --}}
@php
    $capital = 0;
    foreach ($Stocks as $stock) {
        $capital += ($stock->prix_achat * $stock->Quantite);
    }
@endphp

<div class="alert alert-info mt-3">
    <strong>Capital de la société :</strong> {{ number_format($capital, 2, ',', ' ') }} MAD
</div>

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                    <table id="datatable" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>@lang('messages.Designation')</th>
                                <th>@lang('messages.Détails')</th>
                                <th>@lang('Prix ttc')</th>
                                <th>@lang('messages.Quantité')</th>
                                <th>Catégorie</th>
                                <th>Marque</th>
                                <th>Fournisseur</th>
                                @if (auth()->user()->can('show one article') || auth()->user()->can('delete article') || auth()->user()->can('update article'))
                                    <th class="noExport">@lang('messages.Opération')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Stocks as $stock)
                                <tr>
                                    <td>{{ $stock->designation }}</td>
                                    <td>
                                        <?php
                                            $firstLine = strtok($stock->Details, "\n");
                                            $firstLine = str_replace("\n", "", $firstLine);
                                            $truncated = strlen($stock->Details) > strlen($firstLine) ? $firstLine . '...' : ($firstLine ?: "<i class='text-secondary'>Il n'y a pas de détails</i>");
                                            echo $truncated;
                                        ?>
                                    </td>
                                    <td>{{ $stock->prix_achat }}</td>
                                    <td>{{ $stock->Quantite }}</td>
                                    <td>{{ $stock->CategorieProduit?->categorie ?? 'Non défini' }}</td>
                                    <td>{{ $stock->marque?->nom ?? 'Non défini' }}</td>
                                    <td>{{ $stock->fournisseur?->nom ?? 'Non défini' }}</td>
                                    @if (auth()->user()->can('show one article') || auth()->user()->can('delete stock') || auth()->user()->can('update stock'))
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if (auth()->user()->can('show one article'))
                                                <button type="button" class="btn btn-info btn-sm" title="Voir"
                                                    data-bs-toggle="modal" data-bs-target="#viewStockModal{{ $stock->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @include('stock.show', ['stock' => $stock])
                                                @endif

                                                @if (auth()->user()->can('update article'))
                                                <a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-warning btn-sm" title="Éditer">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endif

                                                @if (auth()->user()->can('delete article'))
                                                <button type="button" class="btn btn-danger btn-sm" title="Supprimer"
                                                    data-bs-toggle="modal" data-bs-target="#deleteStockModal{{ $stock->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @include('stock.delete', ['stock' => $stock])
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
