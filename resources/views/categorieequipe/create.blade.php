<!-- resources/views/categorieequipes/create.blade.php -->

@extends('layouts.app')

@section('content')
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="container">
                        <h1>ajouter une categorie</h1>
                        <form action="{{ route('categorieequipe.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">enregitrer</button>
                            <a href="{{ route('categorieequipe.index') }}" class="btn btn-secondary">retour</a>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </section>
@endsection
