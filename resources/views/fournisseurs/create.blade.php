@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Fournisseur</h1>

    <form action="{{ route('fournisseurs.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="num" class="form-label">Numéro Fournisseur</label>
                <input type="text" name="num" id="num" class="form-control" value="{{ $nextNumFormatted }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom du Fournisseur</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ste" class="form-label">Société (STE)</label>
                <input type="text" name="ste" id="ste" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="ice" class="form-label">ICE</label>
                <input type="text" name="ice" id="ice" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="tel" class="form-label">Téléphone</label>
                <input type="text" name="tel" id="tel" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
