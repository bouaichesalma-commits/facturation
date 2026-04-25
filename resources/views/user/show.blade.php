@extends('layouts.app')

@section('content')
    <section class="section profile ">
        <div class="triangless"></div>
        <div class="row ">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ asset( $user->photo) }}" alt="Profil" class="rounded-circle">
                        <h2>{{ $user->prenom }} {{ $user->nom }}</h2>
                        <h3>{{$Namerole}}</h3>
                  
                    </div>
                </div>
            </div>
            
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"
                                    aria-selected="true" role="tab">Overview</button>
                            </li>

                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                                    aria-selected="false" role="tab" tabindex="-1">Changer Mot de passe</button>
                            </li> --}}


                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                                <h5 class="card-title">Profil Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nom</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->nom }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Prénom</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->prenom }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>

                                <h5 class="card-title">Autorisation </h5>
                                <div class="row px-5">
                                @forelse ($NamePermission as $namP)
                                    <div class="col-lg-6 col-md-6 label ">{{$namP}}</div>
                                
                                    
                                @empty
                                    
                                    <div class="col-lg-6 col-md-6 label ">Aucune Autorisation</div>
                                @endforelse
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
