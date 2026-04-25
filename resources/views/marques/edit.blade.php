@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la marque</h1>

    <form action="{{ route('marques.update', $marque->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" name="id" id="id" class="form-control" value="{{ $marque->id }}" disabled>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom du marque</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $marque->nom) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('marques.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
