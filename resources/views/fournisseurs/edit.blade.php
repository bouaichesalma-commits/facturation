@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Fournisseur</h1>

    <form action="{{ route('fournisseurs.update', $fournisseur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="num" class="form-label">Numéro Fournisseur</label>
                <input type="text" name="num" id="num" class="form-control" value="{{ old('num', $fournisseur->num) }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="nom" class="form-label">Nom du Fournisseur</label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $fournisseur->nom) }}" required>
            </div>
            <!--<div class="col-md-4 mb-3">-->
            <!--    <label for="id" class="form-label">ID (Système)</label>-->
            <!--    <input type="text" name="id" id="id" class="form-control" value="{{ $fournisseur->id }}" disabled>-->
            <!--</div>-->
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="ste" class="form-label">Société (STE)</label>
                <input type="text" name="ste" id="ste" class="form-control" value="{{ old('ste', $fournisseur->ste) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ice" class="form-label">ICE</label>
                <input type="text" name="ice" id="ice" class="form-control" value="{{ old('ice', $fournisseur->ice) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="tel" class="form-label">Téléphone</label>
                <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel', $fournisseur->tel) }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
