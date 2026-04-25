@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Demandes de Stage</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- @if (auth()->user()) --}}
    @if (!auth()->user()->can('List of all devis'))

        <div class="d-flex py-2">
            <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
            <div class="p-2 justify-content-end">
                <a class="pull-right btn btn-primary" href="{{ route('demande.stage.create') }}">Créer une Nouvelle Demande <i class="bi bi-plus-lg"></i></a>
            </div>
        </div>
    @endif


    <section class="section mt-4">
        <div  class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                        <table id="datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    {{-- <th>CV</th>
                                    <th>Lettre de Motivation</th> --}}
                                    <th>Demande DE Stage</th>
                                    @if (auth()->check())
                                       <th class="noExport">Opération</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($demandes as $demande)
                                    <tr>
                                        <td>{{ $demande->name }}</td>
                                        <td>{{ $demande->email }}</td>
                                        <td>{{ $demande->message }}</td>
                                        {{-- <td>
                                            @if ($demande->cv)
                                                <a href="{{ route('demande.download', $demande->id) }}">Télécharger CV</a>
                                            @else
                                                Pas de CV fourni.
                                            @endif
                                        </td>
                                        <td>
                                            @if ($demande->lettre_motivation)
                                                <a href="{{ route('demande.download', $demande->id) }}">Télécharger Lettre</a>
                                            @else
                                                Pas de lettre fournie.
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if ($demande->cv || $demande->lettre_motivation)
                                                <a href="{{ route('demande.downloadpage', $demande->id) }}" class="primary">Télécharger Documents</a>
                                            @else
                                                Pas de documents fournis.
                                            @endif
                                        </td>
                                        
                                        
                                        @if (auth()->check())
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#detailsModal">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <a href="{{ route('demande.stage.edit', ['id' => $demande->id]) }}" class="btn text-warning me-1">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                  
                                                    <div class="modal fade" id="detailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content p-2">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fw-bold text-center" id="detailsModalLabel">Détails de la Demande</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-borderless table-striped">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>Nom</th>
                                                                                <td>{{ $demande->name }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Email</th>
                                                                                <td>{{ $demande->email }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Message</th>
                                                                                <td>{{ $demande->message }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>CV</th>
                                                                                <td>
                                                                                    @if ($demande->cv)
                                                                                        <a href="{{ asset('storage/' . $demande->cv) }}" target="_blank">Voir / CV</a>
                                                                                    @else
                                                                                        Pas de CV fourni.
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Lettre de Motivation</th>
                                                                                <td>
                                                                                    @if ($demande->lettre_motivation)
                                                                                        <a href="{{ asset('storage/' . $demande->lettre_motivation) }}" target="_blank">Voir / Lettre de Motivation</a>
                                                                                    @else
                                                                                        Pas de lettre fournie.
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                    <a href="{{ route('demande.index') }}" class="btn btn-primary">Retour à la liste</a>
                                                                    <a href="{{ route('demande.stage.edit', $demande->id) }}" class="btn btn-warning">Modifier</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="d-inline-flex me-2 mb-2">
                                                    <button type="button" class="btn text-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $demande->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <a href="{{ route('demande.stage.edit', ['id' => $demande->id]) }}" class="btn text-black me-1" target="_blank">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </a>
                                                    <div class="modal fade" id="deleteModal{{ $demande->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $demande->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $demande->id }}">Supprimer la demande</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer cette demande ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('demande.destroy', $demande->id) }}" method="POST">
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
    {{--! <script>
        function viewCV(url) {
            window.open(url, '_blank');
        }
    </script> --}}
</div>
@endsection



















{{-- 
<div class="d-inline-flex me-2 mb-2">
    <button type="button" class="btn text-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $demande->id }}">
        <i class="bi bi-eye"></i>
    </button>

    <button onclick="viewCV('{{ asset('storage/' . $demande->cv) }}')">
        <i class="fas fa-file-alt"></i>
    </button>

    
    <div  class="modal fade" id="viewModal{{ $demande->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $demande->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel{{ $demande->id }}">Détails de la demande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nom: </strong>{{ $demande->name }}</p>
                    <p><strong>Email: </strong>{{ $demande->email }}</p>
                    <p><strong>Message: </strong>{{ $demande->message }}</p>
                    <p><strong>CV:</strong> @if ($demande->cv) <a href="{{ asset('storage/'.$demande->cv) }}" target="_blank">Voir/Télécharger CV</a> @else Non disponible @endif</p>
                    <p><strong>Demande de Stage:</strong> @if ($demande->lettre_motivation) <a href="{{ asset('storage/' . $demande->lettre_motivation) }}" target="_blank">Voir/Télécharger Demande</a> @else Non disponible @endif</p>
                </div>
            </div>
        </div>
    </div> --}}










