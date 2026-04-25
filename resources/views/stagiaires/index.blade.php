@extends('layouts.app')

@section('content')

@if (auth())
    <div class="d-flex py-2">
        <!-- Heading -->
        <h1 class="h1 p-2 flex-grow-1 align-items-start">Liste des Stagiaires</h1>

        <!-- Buttons Section -->
        <div class="p-2 d-flex justify-content-end">
            <!-- Button: Catégories -->
            <a class="btn btn-primary me-3" href="{{ route('categorie_stagiaires.index') }}">
                <i class="bi bi-tag"></i> Catégories
            </a>

            <!-- Button: Ajouter un Stagiaire -->
            <a class="btn btn-primary" href="{{ route('stagiaires.create') }}">
                Ajouter un Stagiaire <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
@endif


<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll">
                    <table id="datatable" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Portfolio</th>
                                <th>CV</th>
                                <th>Demande de Stage</th>
                                @if (auth())
                                    <th>Opérations</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stagiaires as $stagiaire)
                                <tr>
                                    <td>{{ $stagiaire->name }}</td>
                                    <td>{{ $stagiaire->telephone }}</td>
                                    <td>{{ $stagiaire->email }}</td>
                                    <td><a href="{{ $stagiaire->portfolio_link }}" target="_blank">Voir Portfolio</a></td>
                                    <td><a href="{{ Storage::url($stagiaire->cv_path) }}" target="_blank">Télécharger CV</a></td>
                                    <td><a href="{{ Storage::url($stagiaire->demande_stage_path) }}" target="_blank">Télécharger Demande</a></td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <!-- View button -->
                                                <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $stagiaire->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <!-- View Modal -->
                                                <div class="modal fade" id="viewModal{{ $stagiaire->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $stagiaire->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewModalLabel{{ $stagiaire->id }}">Détails du Stagiaire</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Nom:</strong> {{ $stagiaire->name }}</p>
                                                                <p><strong>Téléphone:</strong> {{ $stagiaire->telephone }}</p>
                                                                <p><strong>Email:</strong> {{ $stagiaire->email }}</p>
                                                                <p><strong>Portfolio:</strong> <a href="{{ $stagiaire->portfolio_link }}">{{ $stagiaire->portfolio_link }}</a></p>
                                                                <p><strong>Description:</strong> {{ $stagiaire->description }}</p>
                                                                <p><strong>CV:</strong> @if ($stagiaire->cv_path) <a href="{{ Storage::url($stagiaire->cv_path) }}" target="_blank">Voir/Télécharger CV</a> @else Non disponible @endif</p>
                                                                <p><strong>Demande de Stage:</strong> @if ($stagiaire->demande_stage_path) <a href="{{ Storage::url($stagiaire->demande_stage_path) }}" target="_blank">Voir/Télécharger Demande</a> @else Non disponible @endif</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit button -->
                                                <a href="{{ route('stagiaires.edit', $stagiaire->id) }}" class="btn text-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <!-- Delete button -->
                                                <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $stagiaire->id }}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $stagiaire->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $stagiaire->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $stagiaire->id }}">Supprimer le Stagiaire</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Êtes-vous sûr de vouloir supprimer ce stagiaire ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('stagiaires.destroy', $stagiaire->id) }}" method="POST">
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
