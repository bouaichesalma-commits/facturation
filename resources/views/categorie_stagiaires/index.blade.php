@extends('layouts.app')

@section('content')
<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start">Liste des Catégories de Stagiaires</h1>
    <a class="btn btn-primary" href="{{ route('categorie_stagiaires.create') }}">
        Ajouter une Catégorie <i class="bi bi-plus-lg"></i>
    </a>
</div>

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll">
                    <table class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Opérations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                                <tr>
                                    <td>{{ $categorie->nom }}</td>
                                    <td>{{ $categorie->description }}</td>
                                    <td>
                                        <a href="{{ route('categorie_stagiaires.edit', $categorie->id) }}" class="btn text-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('categorie_stagiaires.destroy', $categorie->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
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
