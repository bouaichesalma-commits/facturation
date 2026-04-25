{{-- <!-- resources/views/projects/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>Créer un Projet</h1>
                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="client_id" class="form-label">Client</label>
                                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                        <option></option>
                                        @foreach ($clients as $client)
                                            <option @if(old('client_id') == $client->id) selected @endif value="{{ $client->id }}">
                                                {{ $client->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="equipe_id" class="form-label">Équipe</label>
                                    <select name="equipe_id" id="equipe_id" class="form-control" required>
                                        <option value="">Sélectionner une Équipe</option>
                                        @foreach ($equipes as $equipe)
                                            <option value="{{ $equipe->id }}">{{ $equipe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="categorieproject_id" class="form-label">Catégorie</label>
                                    <select name="categorieproject_id" id="categorieproject_id" class="form-control" required>
                                        <option value="">Sélectionner une Catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Date de début</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">Date de fin</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card p-md-3 p-lg-4">
            <div class="container">
                <h1>Créer un Projet</h1>
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <!-- Existing fields -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="client_id" class="form-label">Client</label>
                            <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                <option></option>
                                @foreach ($clients as $client)
                                    <option @if(old('client_id') == $client->id) selected @endif value="{{ $client->id }}">
                                        {{ $client->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Existing fields -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="equipe_id" class="form-label">Équipe</label>
                            <select name="equipe_id" id="equipe_id" class="form-control" required>
                                <option value="">Sélectionner une Équipe</option>
                                @foreach ($equipes as $equipe)
                                    <option value="{{ $equipe->id }}">{{ $equipe->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="categorieproject_id" class="form-label">Catégorie</label>
                            <select name="categorieproject_id" id="categorieproject_id" class="form-control" required>
                                <option value="">Sélectionner une Catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Existing fields -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Date de début</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                    </div>

                   
                    

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Créer</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Annuler</a>
                </form>

               
            </div>
        </div>
    </div>
</div>
@endsection
