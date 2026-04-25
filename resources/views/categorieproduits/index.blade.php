@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Catégories de Produits</h1>

    <a href="{{ route('categorieproduits.create') }}" class="btn btn-primary mb-3">Ajouter une Catégorie</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $categorie)
            <tr>
                <td>{{ $categorie->id }}</td>
                <td>{{ $categorie->categorie }}</td>
                <td>
                    
                    <a href="{{ route('categorieproduits.edit', $categorie->id) }}" class="btn btn-warning" title="Éditer" style=" padding: 3px 9px;  font-size: 16px;">
                        <i class="fas fa-edit" ></i>
                    </a>



                    <form action="{{ route('categorieproduits.destroy', $categorie->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Supprimer" style=" padding: 3px 9px;  font-size: 16px;">
                            <i class="fas fa-trash" ></i>
                        </button>
                    </form>
            
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
