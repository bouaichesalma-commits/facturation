<!-- resources/views/categorie_attestations/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>Créer une Catégorie d'Attestation</h1>
                        <form action="{{ route('categorie_attestations.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer</button>
                            <a href="{{ route('categorie_attestations.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection

