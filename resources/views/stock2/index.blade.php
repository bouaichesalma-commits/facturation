@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion du Stock</h1>

    <!-- Formulaire de filtre par année -->
    <form method="GET" action="{{ route('stock.index') }}">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label for="year">Choisir l'année:</label>
                <select name="year" id="year" onchange="this.form.submit()">
                    <option value="">-- Sélectionner l'année --</option>
                    @for ($i = 2012; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </form>

    <!-- Table des produits -->
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                        <table id="datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Liste des produits</th>
                                    <th>Prix d'achat</th>
                                    <th>Categorie </th>
                                    <th>Marque </th>
                                    <th>Fournisseur</th>
                                    <th>Quantité</th>
                                    <th class="noExport">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->designation }}</td>
                                        <td>{{ $article->prix_achat }}</td>
                                         <td>
                                            {{ $article->CategorieProduit?->categorie   }}
                                        </td>
                                        <td>
                                            {{ $article->Marque?->nom ?? 'Non défini'  }}
                                        </td>
                                        <td>
                                            {{ $article->Fournisseur?->nom ?? 'Non défini'  }}
                                        </td>
                                        <td>{{ $article->Quantite }}</td>
                                        @if (auth()->user()->can('show one article')||auth()->user()->can('delete article')||auth()->user()->can('update article'))
                                        <td>
                                            @livewire('article-component', ['id' => $article['id']])
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
</div>
@endsection
