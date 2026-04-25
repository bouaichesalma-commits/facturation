@extends('layouts.app')

@section('content')

<div class="d-flex py-2">
    <!-- Heading -->
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>

    <!-- Buttons Section -->
    <div class="p-2 d-flex justify-content-end">
        <!-- Button: categorie projet -->
        <a class="btn btn-primary me-3" href="{{ route('categorieprojects.index') }}">
            <i class="bi bi-grid"></i> Catégorie Projet
        </a>

        <!-- Button: Ajouter un Projet -->
        <a class="btn btn-primary" href="{{ route('projects.create') }}">
            Ajouter un Projet <i class="bi bi-plus-lg"></i>
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
                                <th>Nom</th>
                                <th>Client</th>
                                <th>Équipe</th>
                                <th>Catégorie</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Description</th>
                                @if (auth())
                                    <th class="noExport">Opération</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client ? $project->client->nom : 'N/A' }}</td>
                                    <td>{{ $project->equipe ? $project->equipe->name : 'N/A' }}</td>
                                    <td>{{ $project->categorieproject ? $project->categorieproject->name : 'N/A' }}</td>
                                    <td>{{ $project->start_date }}</td>
                                    <td>{{ $project->end_date }}</td>
                                    <td>{{ $project->description }}</td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-inline-flex me-2 mb-2">
                                                    @if (auth())
                                                    <!-- Bouton Voir -->
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $project->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Modal Voir -->
                                                    <div class="modal fade" id="viewModal{{ $project->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $project->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel{{ $project->id }}">Détails du projet</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Nom :</strong> {{ $project->name }}</p>
                                                                    <p><strong>Client :</strong> {{ $project->client ? $project->client->nom : 'N/A' }}</p>
                                                                    <p><strong>Équipe :</strong> {{ $project->equipe ? $project->equipe->name : 'N/A' }}</p>
                                                                    <p><strong>Catégorie :</strong> {{ $project->categorieproject ? $project->categorieproject->name : 'N/A' }}</p>
                                                                    <p><strong>Date de début :</strong> {{ $project->start_date }}</p>
                                                                    <p><strong>Date de fin :</strong> {{ $project->end_date }}</p>
                                                                    <p><strong>Description :</strong> {{ $project->description }}</p>
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
                                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn text-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="d-inline-flex me-2 mb-2">
                                                    @if (auth())
                                                    <!-- Bouton Supprimer -->
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $project->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <!-- Modal Supprimer -->
                                                    <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $project->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $project->id }}">Supprimer le projet</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer ce projet ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
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

