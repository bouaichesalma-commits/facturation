<!-- resources/views/categorie_attestations/index.blade.php -->

@extends('layouts.app')

@section('content')

<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
    <div class="p-2 justify-content-end">
        <a class="pull-right btn btn-primary" href="{{ route('categorie_attestations.create') }}">Ajouter une Catégorie d'Attestation <i class="bi bi-plus-lg"></i></a>
    </div>
</div>

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                    <table id="datatable" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                @if (auth())
                                    <th class="noExport">Opération</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorieAttestations as $categorieAttestation)
                                <tr>
                                    <td>{{ $categorieAttestation->name }}</td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-inline-flex me-2 mb-2">
                                                    @if (auth())
                                                    <!-- Bouton Voir -->
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $categorieAttestation->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Modal Voir -->
                                                    <div class="modal fade" id="viewModal{{ $categorieAttestation->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $categorieAttestation->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel{{ $categorieAttestation->id }}">Détails de la Catégorie d'Attestation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Nom :</strong> {{ $categorieAttestation->name }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (auth())
                                                    <!-- Bouton Éditer -->
                                                    <a href="{{ route('categorie_attestations.edit', $categorieAttestation->id) }}" class="btn text-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="d-inline-flex me-2 mb-2">
                                                    @if (auth())
                                                    <!-- Bouton Supprimer -->
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $categorieAttestation->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <!-- Modal Supprimer -->
                                                    <div class="modal fade" id="deleteModal{{ $categorieAttestation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $categorieAttestation->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $categorieAttestation->id }}">Supprimer la Catégorie d'Attestation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer cette catégorie d'attestation ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('categorie_attestations.destroy', $categorieAttestation->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    @endif
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
