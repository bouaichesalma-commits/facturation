@extends('layouts.app')

@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ asset('storage/images/' . Auth::user()->photo) }}" alt="Profil" class="rounded-circle">
                        <h2>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
                        <h3>Admin</h3>
                     
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#notification-overview"
                                    aria-selected="true" role="tab">Overview</button>
                            </li>


                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade notification-overview active show" id="notification-overview" role="tabpanel">
                                <h5 class="card-title">Notification Date expiration Client</h5>
                                @foreach ( $clientDatExp as $Client )
                                    
                                    <div class="row bg-danger my-2">
                                        <div class="col-lg-3 col-md-4 label ">Nom CLient : </div>
                                        <div class="col-lg-9 col-md-8">{{ $Client->nom }}</div>
                                        <div class="col-lg-3 col-md-4 label ">Date Expiration : </div>
                                        <div class="col-lg-9 col-md-8">{{ $Client->DateExpiration }}</div>
                                    </div>
                                @endforeach

                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
