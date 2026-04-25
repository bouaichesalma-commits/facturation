@extends('layouts.app')

@section('content')
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body">
                        @if (session()->has('info'))
                            <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0">{{ session('info') }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('client.store') }}" class="row g-3">
                            @csrf
                            <div class="col-md-12">
                                <label for="inputNom" class="form-label">Nom et prénom :</label>
                                <input type="text" name="nom" value="{{old('nom')}}" class="form-control @error('nom') is-invalid @enderror" id="inputNom" placeholder="Veuillez saisir ici ...">
                                @error('nom')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12" style="">
                                <label for="inputNom_societe" class="form-label">Nom de société :</label>
                                <input type="text" name="nom_societe" value="{{old('nom_societe')}}" class="form-control @error('nom_societe') is-invalid @enderror" id="inputNom_societe" placeholder="Veuillez saisir ici ...">
                                @error('nom_societe')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="col-md-12">
                                <label for="inputIce" class="form-label">ICE :</label>
                                <input type="text" name="ice" value="{{old('ice')}}" class="form-control" id="inputIce" placeholder="Veuillez saisir ici ...">
                                @error('ice')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="inputTelephone" class="form-label">Téléphone :</label>
                                <input type="text" name="tel" value="{{old('tel')}}" class="form-control @error('tel') is-invalid @enderror" id="inputTelephone" placeholder="Veuillez saisir ici ...">
                                @error('tel')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="inputAdresse" class="form-label">Ville - Adresse :</label>
                                <input type="text" name="adresse" value="{{old('adresse')}}" class="form-control @error('adresse') is-invalid @enderror" id="inputAdresse" placeholder="Veuillez saisir ici ...">
                                @error('adresse')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label for="inputEmail" class="form-label">Email :</label>
                                <input type="text" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Veuillez saisir ici ...">
                                @error('email')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                        

                            
                           

                            <div class="text-center mt-5">
                                <button type="reset" class="btn btn-secondary">Effacer</button>
                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault();this.disabled = true; this.closest('form').submit();" >Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        
            // change input etatDateExp
            
            if ($('#etatDateExp').prop("checked") == true) $('#inputdateEXP').removeAttr('disabled')
                    if ($('#etatDateExp').prop("checked") == false) {
                        $('#inputdateEXP').attr('disabled', 'disabled')
                    }
                    $('#etatDateExp').click(function() {
                        if ($(this).prop("checked") == true) $('#inputdateEXP').removeAttr('disabled')
                        if ($(this).prop("checked") == false) {
                            
                    
                            $('#inputdateEXP').attr('disabled', 'disabled');
                    }
                    });

                // End change input tva
    </script>
@endsection
