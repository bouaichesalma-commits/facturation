@extends('layouts.app')

@section('content')

<div class="d-flex py-2">
    <!-- Heading -->
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>

    <!-- Buttons Section -->
    <div class="p-2 d-flex justify-content-end">
        <!-- Button: categorie d'attestations -->
        <a class="btn btn-primary me-3" href="{{ route('categorie_attestations.index') }}">
            <i class="bi bi-grid"></i> Catégorie d'attestations
        </a>

        <!-- Button: Ajouter une Attestation -->
        <a class="btn btn-primary" href="{{ route('attestations.create') }}">
            Ajouter une attestation <i class="bi bi-plus-lg"></i>
        </a>
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
                                <th>Équipe</th>
                                <th>Catégories</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Date de signature</th>
                                @if (auth())
                                    <th class="noExport">Opération</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attestations as $attestation)
                                <tr>
                                    <td>{{ $attestation->equipe->name }}</td>
                                    <td>{{ $attestation->categorieAttestation->name }}</td>
                                    <td>{{ $attestation->start_date }}</td>
                                    <td>{{ $attestation->end_date }}</td>
                                    <td>{{ $attestation->signature_date }}</td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <!-- Bouton Voir & Éditer -->
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- Bouton Voir -->
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $attestation->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Modal Voir -->
                                                    <div class="modal fade" id="viewModal{{ $attestation->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $attestation->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel{{ $attestation->id }}">Détails de l'attestation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Équipe :</strong> {{ $attestation->equipe->name }}</p>
                                                                    <p><strong>Catégorie Projet :</strong> {{ $attestation->categorieproject->name }}</p>
                                                                    <p><strong>Catégorie Attestation :</strong> {{ $attestation->categorieAttestation->name }}</p>
                                                                    <p><strong>Date de début :</strong> {{ $attestation->start_date }}</p>
                                                                    <p><strong>Date de fin :</strong> {{ $attestation->end_date }}</p>
                                                                    <p><strong>Date de signature :</strong> {{ $attestation->signature_date }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Bouton Éditer -->
                                                    <a href="{{ route('attestations.edit', $attestation->id) }}" class="btn text-warning me-2">
                                                        <i class="bi bi-pencil-square"></i> 
                                                    </a>
                                                </div>
                                                <!-- Bouton Download & Supprimer -->
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- Icon Download -->
                                                    <a href="{{ route('attestations.download', $attestation->id) }}" class="btn text-success me-2">
                                                        <i class="bi bi-file-earmark-text"></i> 
                                                    </a>
                                                    <!-- Bouton Supprimer -->
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $attestation->id }}">
                                                        <i class="bi bi-trash-fill"></i> 
                                                    </button>
                                                    <!-- Modal Supprimer -->
                                                    <div class="modal fade" id="deleteModal{{ $attestation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $attestation->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $attestation->id }}">Supprimer l'attestation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer cette attestation ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('attestations.destroy', $attestation->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
