<!-- resources/views/categorie_attestations/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>Modifier la Catégorie d'Attestation</h1>
                        <form action="{{ route('categorie_attestations.update', $categorieAttestation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $categorieAttestation->name }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            <a href="{{ route('categorie_attestations.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection

