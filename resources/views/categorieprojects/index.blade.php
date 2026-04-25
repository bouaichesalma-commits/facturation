@extends('layouts.app')

@section('content')

@if (auth())
    <div class="d-flex py-2">
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
        <div class="p-2 justify-content-end">
            <a class="pull-right btn btn-primary" href="{{ route('categorieprojects.create') }}">Ajouter une Catégorie de projet <i class="bi bi-plus-lg"></i></a>
        </div>
    </div>
@endif

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
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    @if (auth())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- Bouton Voir -->
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $category->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Modal Voir -->
                                                    <div class="modal fade" id="viewModal{{ $category->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $category->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel{{ $category->id }}">Détails de la Catégorie</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Nom :</strong> {{ $category->name }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Bouton Éditer -->
                                                    <a href="{{ route('categorieprojects.edit', $category->id) }}" class="btn text-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </div>
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <!-- Bouton Supprimer -->
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <!-- Modal Supprimer -->
                                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Supprimer la Catégorie</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer cette catégorie ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('categorieprojects.destroy', $category->id) }}" method="POST">
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
