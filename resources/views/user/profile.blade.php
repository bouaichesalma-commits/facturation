@extends('layouts.app')

@section("content")
<div class="pagetitle">
    <h1>Mon profile</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profile') }}">@lang('messages.Utilisateur')</a></li>
        <li class="breadcrumb-item active">profile</li> 
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8">

        <div class="card">
            <div class="card-body p-md-4 p-lg-5">
                <h5 class="card-title">Mettre à jour profile</h5>

                <form class="row g-3">
                        <div class="col-md-12 m-auto text-center">
                            <div class="row g-3">
                                <h5 class="mb-2 mt-4">Chargez votre photo de profil</h5>
                                <div class="text-center">
                                    <!-- Image upload -->
                                    <div class="square position-relative display-2 mb-3">
                                    <img class="rounded-circle" src="{{ asset('img/profile-img.jpg') }}" alt="">
                                    </div>
                                    <!-- Button -->
                                    <input type="file" id="inputFile" name="file" hidden="">
                                    <label class="btn btn-outline-success btn-sm" for="inputFile">
                                        <i class="bi bi-pencil-square"></i>
                                    </label>
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <!-- Content -->
                                    <p class="text-muted mt-3 mb-0"><span class="me-1">Remarque :</span> Taille minimale  300 px x 300 px</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputNom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="inputNom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPrenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="inputPrenom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail">
                        </div>
                        <div class="col-md-6">
                            <label for="inputTel" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="inputTel">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword1" class="form-label">Mot de pass</label>
                            <input type="password" class="form-control" id="inputPassword1">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword2" class="form-label">Confirmer Mot de pass</label>
                            <input type="password" class="form-control" id="inputPassword2">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
