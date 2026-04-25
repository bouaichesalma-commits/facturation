@extends('layouts.app')

@section('content')
<div id="Receipt" class="container">
    <h1 class="text-center">Lettre de Demande de Stage</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        <div class="card p-4" style="width: 600px;">
            <div class="card-body">
                <h5 class="card-title text-center">Informations du Demandeur</h5>

                <p><strong>Nom:</strong> {{ $demande->name }}</p>
                <p><strong>Email:</strong> {{ $demande->email }}</p>

                {{-- <h5 class="text-center mt-4">Détails de la Demande</h5> --}}

                {{-- <p><strong>CV:</strong></p>
                @if ($demande->cv)
                    <button class="btn btn-primary mb-3" onclick="viewCV('{{ asset('storage/' . $demande->cv) }}')">Afficher CV</button>
                @else
                    <span>Pas de CV fourni.</span>
                @endif

                <p><strong>Lettre de Motivation:</strong></p>
                @if ($demande->lettre_motivation)
                    <button class="btn btn-primary" onclick="viewLetter('{{ asset('storage/' . $demande->lettre_motivation) }}')">Afficher Lettre</button>
                @else
                    <span>Pas de lettre fournie.</span>
                @endif --}}

                <div class="mt-4 text-center">
                    <h5 class="card-title">Message de Demande</h5>
                    <p>{{ $demande->message }}</p> <!-- Assurez-vous que la colonne 'message' existe dans votre modèle -->
                </div>
            </div>
        </div>
    </div>
</div>
<a href="{{ route('demande.index') }}" class="btn btn-secondary mt-3">Retour</a>
<button id="print" onclick="printContent('Receipt');" class="btn btn-success  text-justify mt-3">
    Print <span class="fas fa-print"></span>
</button>


{{-- Script pour afficher le CV et la lettre --}}
<script>
    function viewCV(url) {
        window.open(url, '_blank');
    }

    function viewLetter(url) {
        window.open(url, '_blank');
    }
</script>
<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
}
</script>


@endsection





// <script>
//     function viewCV(url) {
//         window.open(url, '_blank');
//     }

//     function viewLetter(url) {
//         window.open(url, '_blank');
//     }
// </script> --}}