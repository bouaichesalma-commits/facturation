<!-- resources/views/equipes/index.blade.php -->

@extends('layouts.app')

@section('content')

@if (auth())
    <div class="d-flex py-2">
        <!-- Heading -->
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
        
        <!-- Buttons Section -->
        <div class="p-2 d-flex justify-content-end">
            <!-- Button: Catégorie d'équipe -->
            @if (auth()->user()->can('List of all cathegoriequipe'))
                <a class="btn btn-primary me-3" href="{{ route('categorieequipe.index') }}">
                    <i class="bi bi-grid"></i> Catégorie d'équipe
                </a>
            @endif
            
            <!-- Button: Ajouter une Équipe -->
            <a class="btn btn-primary" href="{{ route('equipe.create') }}">
                Ajouter une Équipe <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
@endif

{{-- <button id="showCategorieEquipeBtn" class="btn btn-primary mb-3">Catégorie d'Équipe</button> --}}

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body p-3 overflow-x-scroll" id="contentSection">
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
                                    <th class="noExport">Opération</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipes as $equipe)
                                <tr>
                                    <td>{{ $equipe->name }}</td>
                                    <td>{{ $equipe->telephone }}</td>
                                    <td>{{ $equipe->email }}</td>
                                    <td><a href="{{ $equipe->portfolio_link }}" target="_blank">{{ $equipe->portfolio_link }}</a></td>
                                    <td>
                                        <a href="{{ route('download-cv', ['id' => $equipe->id]) }}">Télécharger CV</a>
                                            <!-- Debugging line to check the cv_path -->
                                    </td>
                                    <td>
                                    <a href="{{ route('download-demande', ['id' => $equipe->id]) }}">Télécharger CV</a>
                                    </td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- View button -->
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $equipe->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- View Modal -->
                                                    <div class="modal fade" id="viewModal{{ $equipe->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $equipe->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel{{ $equipe->id }}">Détails de l'équipe</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Nom:</strong> {{ $equipe->name }}</p>
                                                                    <p><strong>Catégorie:</strong> {{ $equipe->categorieequipe->name }}</p>
                                                                    <p><strong>Téléphone:</strong> {{ $equipe->telephone }}</p>
                                                                    <p><strong>Email:</strong> {{ $equipe->email }}</p>
                                                                    <p><strong>Adresse:</strong> {{ $equipe->adresse }}</p>
                                                                    <p><strong>Portfolio:</strong> <a href="{{ $equipe->portfolio_link }}">{{ $equipe->portfolio_link }}</a></p>
                                                                    <p><strong>Description:</strong> {{ $equipe->description }}</p>
                                                                    <p><strong>CV:</strong> @if ($equipe->cv_path) <a href="{{ Storage::url($equipe->cv_path) }}" target="_blank">Voir/Télécharger CV</a> @else Non disponible @endif</p>
                                                                    <p><strong>Demande de Stage:</strong> @if ($equipe->demande_stage_path) <a href="{{ Storage::url($equipe->demande_stage_path) }}" target="_blank">Voir/Télécharger Demande</a> @else Non disponible @endif</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Edit button -->
                                                    <a href="{{ route('equipe.edit', $equipe->id) }}" class="btn text-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </div>
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- Delete button -->
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $equipe->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $equipe->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $equipe->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $equipe->id }}">Supprimer l'équipe</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                     Etes-vous sûr de vouloir supprimer cette équipe?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('equipe.destroy', $equipe->id) }}" method="POST">
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
{{-- <livewire:chat /> --}}
@endsection
