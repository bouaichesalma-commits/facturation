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
                        <form method="POST" action="{{ route('client.update', $client['id']) }}" class="row g-3" id="formEditClient">
                            @csrf
                            @method("PUT")
                            <div class="col-md-12">
                                <label for="inputNom" class="form-label">Nom et prénom  :</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" id="inputNom" value="{{ old('nom') ? old('nom') : $client['nom'] }}">
                                @error('nom')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12">
                                <label for="inputNom_societe" class="form-label">Nom de société  :</label>
                                <input type="text" name="nom_societe" class="form-control @error('nom_societe') is-invalid @enderror" id="inputNom_societe" value="{{ old('nom_societe') ? old('nom_societe') : $client['nom_societe'] }}">
                                @error('nom_societe')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            <div class="col-md-12">
                                <label for="inputIce" class="form-label">ICE :</label>
                                <input type="text" name="ice" class="form-control" id="inputIce" value="{{ old('ice') ? old('ice') : $client['ice'] }}">
                                @error('ice')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="inputTelephone" class="form-label">Téléphone :</label>
                                <input type="tel" name="tel" class="form-control @error('tel') is-invalid @enderror" id="inputTelephone" value="{{ old('tel') ? old('tel') : $client['tel'] }}">
                                @error('tel')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="inputAdresse" class="form-label">Ville :</label>
                                <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" id="inputAdresse" value="{{ old('adresse') ? old('adresse') : $client['adresse'] }}">
                                @error('adresse')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="inputEmail" class="form-label">Email :</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" value="{{ old('email') ? old('email') : $client['email'] }}">
                                @error('email')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-5">
                                <a href="{{ route('client.index') }}" class="btn btn-secondary">Retour</a>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        $(document).ready(() => {
        
        // change input etatDateExp
        
        if ($('#etatDateExp').prop("checked") == true) {
            $('#inputdateEXP').removeAttr('readonly')
        
            $("#inputdateEXP").css("background-color", "#fff");

        }
                if ($('#etatDateExp').prop("checked") == false) {

                    $("#inputdateEXP").css("background-color", "#84A7A1");
                    $('#inputdateEXP').attr('readonly', 'readonly')
                    
                }
                $('#etatDateExp').click(function() {
                    if ($(this).prop("checked") == true) {

                        $('#inputdateEXP').removeAttr('readonly')
                    
                        $("#inputdateEXP").css("background-color", "#fff");
                        
                    }
                    if ($(this).prop("checked") == false) {
                        
                        
                        $("#inputdateEXP").css("background-color", "#84A7A1");
                        $('#inputdateEXP').val("")
                        $('#inputdateEXP').attr('readonly', 'readonly');
                }
                });

            // End change input etatDateExp
            $('#formEditClient').submit(function() {
                // Check the state of the etatDateExp checkbox
                if (!$('#etatDateExp').is(':checked')) {
                    
                    $('#inputdateEXP').val("")
                    $('#etatDateEXPhidden').val(null);
                }else{
                    $('#etatDateEXPhidden').val('on');
                }
            });
            
            });
</script>
@endsection
