@extends('layouts.app')

@section('content')
    <style>
        .profile-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }
        .profile-edit img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
    <section class="section profile ">
        <div class="triangless"></div>
        <div class="row ">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ asset( $user->photo) }}" alt="Profil" class="rounded-circle">
                        <h2>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
                        <h3>{{$user->getRoleNames()->first()}}</h3>
                   
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{session('status')? '' : 'active' }} " data-bs-toggle="tab" data-bs-target="#profile-overview"
                                    aria-selected="{{session('status')? false : true }}" role="tab">Overview</button>
                            </li>

                            @if (auth()->user()->can('update agence'))
                            <li class="nav-item " role="presentation">
                                <button class="nav-link {{session('status') === 'agence-updated'? 'active show' : ''}}" data-bs-toggle="tab" data-bs-target="#agence-edit"
                                    aria-selected="{{session('status') === 'agence-updated'? true : false}}" role="tab" tabindex="-1">Modifier Société</button>
                            </li>

                            @endif

                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{session('status') === 'profile-updated'? 'active show' : ''}}" data-bs-toggle="tab" data-bs-target="#profile-edit"
                                    aria-selected="{{session('status') === 'profile-updated'? true : false}}" role="tab" tabindex="-1">Modifier Profil</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{session('status') === 'password-updated'? 'active show' : ''}}" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                                    aria-selected="{{session('status') === 'password-updated'? true : false}}" role="tab" tabindex="-1">Changer Mot de passe</button>
                            </li>
 
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-delete"
                                    aria-selected="false" role="tab" tabindex="-1">Supprimer Profile</button>
                            </li> --}}

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade profile-overview  {{session('status')? '' : 'active show' }}" 
                              id="profile-overview" role="tabpanel">
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
                                @if (auth( )->user()->can('show agence'))
                                    
                                    <h5 class="card-title">Société Infos</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nom</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->nom }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Adresse</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->adresse }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Téléphone</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->gsm }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Fixe</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->fixe }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Site</div>
                                        <div class="col-lg-9 col-md-8">{{ $agence->site }}</div>
                                    </div>
                                @endif
                            </div>
                            @if (auth()->user()->can('update agence'))
                                
                                <div class="tab-pane fade profile-edit pt-3 {{session('status') === 'agence-updated'? 'active show' : ''}}" id="agence-edit" role="tabpanel">
                                    @include('profile.partials.update-agence-information-form')
                                </div>

                            @endif

                            <div class="tab-pane fade profile-edit pt-3 {{session('status') === 'profile-updated'? 'active show' : ''}}" id="profile-edit" role="tabpanel">
                                @include('profile.partials.update-profile-information-form')
                            </div>

                            <div class="tab-pane fade pt-3 {{session('status') === 'password-updated'? 'active show' : ''}}" id="profile-change-password" role="tabpanel">
                                @include('profile.partials.update-password-form')
                            </div>

                            {{-- <div class="tab-pane fade pt-3" id="profile-delete" role="tabpanel">
                                    @include('profile.partials.delete-user-form')
                            </div> --}}

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
