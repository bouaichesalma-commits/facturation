<!-- resources/views/attestations/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>Créer une Attestation</h1>
                        <form action="{{ route('attestations.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="equipe_id" class="form-label">Équipe</label>
                                    <select name="equipe_id" id="equipe_id" class="form-control" required>
                                        <option value="">Sélectionner une Équipe</option>
                                        @foreach ($equipes as $equipe)
                                            <option value="{{ $equipe->id }}">{{ $equipe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="categorieproject_id" class="form-label">Catégorie Projet</label>
                                    <select name="categorieproject_id" id="categorieproject_id" class="form-control" required>
                                        <option value="">Sélectionner une Catégorie Projet</option>
                                        @foreach ($categorieProjects as $categorieProject)
                                            <option value="{{ $categorieProject->id }}">{{ $categorieProject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="categorie_attestation_id" class="form-label">Catégorie Attestation</label>
                                    <select name="categorie_attestation_id" id="categorie_attestation_id" class="form-control" required>
                                        <option value="">Sélectionner une Catégorie Attestation</option>
                                        @foreach ($categorieAttestations as $categorieAttestation)
                                            <option value="{{ $categorieAttestation->id }}">{{ $categorieAttestation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Date de début</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">Date de fin</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="signature_date" class="form-label">Date de signature</label>
                                    <input type="date" name="signature_date" id="signature_date" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer</button>
                            <a href="{{ route('attestations.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection
