@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une marque</h1>

    <form action="{{ route('marques.store') }}" method="POST">
        @csrf
    
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du marque</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
      

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
