@extends('layouts.app')

@section('content')
<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start">Modifier la Catégorie de Stagiaire</h1>
</div>

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body">
                    <form action="{{ route('categorie_stagiaires.update', $categorie->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $categorie->nom }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ $categorie->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
