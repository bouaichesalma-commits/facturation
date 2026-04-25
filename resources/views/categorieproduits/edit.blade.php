@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Catégorie de Produit</h1>

    <form action="{{ route('categorieproduits.update', $categorieproduit->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="categorie" class="form-label">Nom de la Catégorie</label>
            <input type="text" name="categorie" id="categorie" class="form-control" value="{{ old('categorie', $categorieproduit->categorie) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
