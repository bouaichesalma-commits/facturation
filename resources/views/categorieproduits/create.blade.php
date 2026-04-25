@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une Catégorie de Produit</h1>

    <form action="{{ route('categorieproduits.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="categorie" class="form-label">Nom de la Catégorie</label>
            <input type="text" name="categorie" id="categorie" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
