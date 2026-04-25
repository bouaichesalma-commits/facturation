@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h1>Envoyer une Demande de Stage</h1>
    <form action="{{ route('demande.stage.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="cv" class="form-label">CV (PDF ou DOC)</label>
            <input type="file" class="form-control" id="cv" name="cv">
        </div>
        <div class="mb-3">
            <label for="lettre_motivation" class="form-label">Lettre de Motivation (PDF ou DOC)</label>
            <input type="file" class="form-control" id="lettre_motivation" name="lettre_motivation">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    
    
    <a href="{{ route('demande.index') }}" class="btn btn-secondary mt-3">Liste des demandes</a>
</div>
@endsection
