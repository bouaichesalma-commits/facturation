@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>Modifier Équipe</h1>
                        <form action="{{ route('equipe.update', $equipe->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $equipe->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="categorieequipe_id" class="form-label">Catégorie</label>
                                    <select name="categorieequipe_id" id="categorieequipe_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $equipe->categorieequipe_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $equipe->telephone }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $equipe->email }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="adresse" class="form-control" value="{{ $equipe->adresse }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cv" class="form-label">CV</label>
                                    <input type="file" name="cv" id="cv" class="form-control">
                                    @if ($equipe->cv_path)
                                        <a href="{{ Storage::url($equipe->cv_path) }}" target="_blank">Voir CV actuel</a>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="demande_stage" class="form-label">Demande de Stage</label>
                                    <input type="file" name="demande_stage" id="demande_stage" class="form-control">
                                    @if ($equipe->demande_stage_path)
                                        <a href="{{ Storage::url($equipe->demande_stage_path) }}" target="_blank">Voir demande de stage actuelle</a>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="portfolio_link" class="form-label">Lien Portfolio</label>
                                <input type="url" name="portfolio_link" id="portfolio_link" class="form-control" value="{{ $equipe->portfolio_link }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="5">{{ $equipe->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                            <a href="{{ route('equipe.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection

