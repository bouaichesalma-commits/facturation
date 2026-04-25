@extends('layouts.app')

@section('content')
@if (auth()->user()->can('create client'))
<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
    <div class="p-2 justify-content-end">
        <a class="pull-right btn btn-primary" href="{{route('fournisseurs.create')}}">
            @lang('messages.Ajouter un Fournisseur') <i class="bi bi-plus-lg"></i>
        </a>
    </div>
</div>
@endif

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table id="datatable" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom</th>
                                <th>Société</th>
                                <th>ICE</th>
                                <th>Téléphone</th>
                                <th class="noExport">Opération</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fournisseurs as $fournisseur)
                            <tr>
                                <td>{{ $fournisseur->num }}</td>
                                <td>{{ $fournisseur->nom }}</td>
                                <td>{{ $fournisseur->ste }}</td>
                                <td>{{ $fournisseur->ice }}</td>
                                <td>{{ $fournisseur->tel }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}" class="btn btn-warning btn-sm" title="Éditer">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
