{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la Demande</h1>

    <p><strong>Nom: </strong>{{ $demande->name }}</p>
    <p><strong>Email: </strong>{{ $demande->email }}</p>
    <p><strong>Message: </strong>{{ $demande->message }}</p>
    <p>
        <strong>CV: </strong>
        @if ($demande->cv)
            <a href="{{ route('demande.download', $demande->id) }}">Télécharger CV</a>
        @else
            Pas de CV fourni.
        @endif
    </p>
    <p>
        <strong>Lettre de Motivation: </strong>
        @if ($demande->lettre_motivation)
            <a href="{{ route('demande.download', $demande->id) }}">Télécharger Lettre</a>
        @else
            Pas de lettre fournie.
        @endif
    </p>
 

    <a href="{{ route('demande.stage.index') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
@endsection --}}


@extends('layouts.app')

@section('content')
<!-- Bouton pour déclencher la modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal">
    Voir les détails de la demande
</button>

<!-- Modal -->
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
                                    <a href="{{ route('demande.download', $demande->id) }}">Télécharger CV</a>
                                @else
                                    Pas de CV fourni.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Lettre de Motivation</th>
                            <td>
                                @if ($demande->lettre_motivation)
                                    <a href="{{ route('demande.download', $demande->id) }}">Télécharger Lettre</a>
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
            </div>
        </div>
    </div>
</div>
@endsection
