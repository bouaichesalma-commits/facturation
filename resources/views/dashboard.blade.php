@extends('layouts.app')

@section('content')
    <style>
        .loaderWebM {
            position: fixed;
            bottom: 30px;
            right: 30px;
            top: auto;
            left: auto;
            margin: 0;
            width: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
            opacity: 0.5;
            z-index: 9999;
            pointer-events: none;
        }

        @keyframes float {
        0%,
        100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-12px);
        }
        }

        .loaderWebM:before {
        content: "";
        width: 10px;
        height: 7px;
        border-radius: 50%;
        background-color: rgba(188, 40, 40, 0.9);
        position: absolute;
        bottom: -9px;
        animation: shadow046 2s alternate infinite ease;
        }
        @keyframes shadow046 {
        0% {
            transform: scaleX(1);
        }
        40% {
            transform: scaleX(15);
            opacity: 0.7;
        }
        }

    </style>
    <div class="pagetitle">
        <h1>@lang('messages.Tableau de bord')</h1>

        {{-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboards</a></li>
            </ol>
        </nav> --}}
    </div><!-- End Page Title -->

    <section class="section mt-5" style="position: relative;">
        <div class="triangless"></div>
        <div class="loaderWebM ms-5"><img src="{{asset('img/logo.png')}}" width="300" height="100" alt=""></div>
         
      
        <div class="row">
            @if (auth()->user()->can('List of all client'))
                
            <div class="col-md-3">
                <!-- Card -->
                <div class="card rounded-4">
                    <div class="p-3">
                        <div class="row">
                            <div class="col d-flex justify-content-between">

                                <div>
                                    <!-- Title -->
                                    <h6 class="body-title d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        @lang('messages.Total clients')
                                    </h6>

                                    <!-- Subtitle -->
                                    <h3 class="fw-bold mb-0">
                                        {{ $total_clients }}
                                    </h3>

                                    <!-- Comment -->
                                    <p class="mb-0 text-primary">
                                        + {{ $new_clients }} @lang('messages.cette année')
                                    </p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#cf2e2e" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                </svg>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
            @endif
{{--  --}}
            @if (auth()->user()->can('List of all article'))
                
            <div class="col-md-3">
                <!-- Card -->
                <div class="card rounded-4">
                    <div class="p-3">
                        <div class="row">
                            <div class="col d-flex justify-content-between">

                                <div>
                                    <!-- Title -->
                                    <h6 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        <span class="legend-circle-sm bg-danger"></span>
                                        @lang('Total produits')
                                    </h6>

                                    <!-- Subtitle -->
                                    <h3 class="mb-0 fw-bold">
                                        {{ $total_articles }}
                                    </h3>

                                    <!-- Comment -->
                                    <p class="text-primary mb-0">
                                        + {{ $new_articles }} @lang('messages.cette année')
                                    </p>
                                </div>


                                <span class="text-primary mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="32" width="32">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: none;
                                                    stroke: currentColor;
                                                    stroke-linecap: round;
                                                    stroke-linejoin: round;
                                                    stroke-width: 1.5px;
                                                }
                                            </style>
                                        </defs>
                                        <title>cash-briefcase</title>
                                        <path class="a" d="M9.75,15.937c0,.932,1.007,1.688,2.25,1.688s2.25-.756,2.25-1.688S13.243,14.25,12,14.25s-2.25-.756-2.25-1.688,1.007-1.687,2.25-1.687,2.25.755,2.25,1.687"></path>
                                        <line class="a" x1="12" y1="9.75" x2="12" y2="10.875"></line>
                                        <line class="a" x1="12" y1="17.625" x2="12" y2="18.75"></line>
                                        <rect class="a" x="1.5" y="6.75" width="21" height="15" rx="1.5" ry="1.5"></rect>
                                        <path class="a" d="M15.342,3.275A1.5,1.5,0,0,0,13.919,2.25H10.081A1.5,1.5,0,0,0,8.658,3.275L7.5,6.75h9Z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div> <!-- / .row -->

            @endif
            @if (auth()->user()->can('List of all facture'))
                
            <div class="col-md-3">
                <!-- Card -->
                <div class="card container-fluid rounded-4">
                    <div class="py-3 px-2">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h6 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        <span class="legend-circle-sm bg-danger"></span>
                                        @lang('messages.Total factures')
                                    </h6>

                                    <!-- Subtitle -->
                                    <h3 class="mb-0 fw-bold">
                                        {{ $total_factures }}
                                    </h3>
                                </div>

                                <span class="text-primary mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <hr class="text-muted mx-0">
                        <div class="row">
                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <!-- Title -->
                                    <p class="text-muted mb-1">
                                        @lang('messages.Payées')
                                    </p>
                                    <!-- Subtitle -->
                                    <h4 class="mb-0 fw-semibold">
                                        {{ $paid_factures }}
                                    </h4>
                                </div>
                                <div>
                                    <!-- Title -->
                                    <p class="text-muted mb-1">
                                        @lang('messages.Impayées')
                                    </p>
                                    <!-- Subtitle -->
                                    <h4 class="mb-0 fw-semibold">
                                        {{ $unpaid_factures }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- / .row -->
                    </div>
                </div>
            </div>
            
            @endif
            @if (auth()->user()->can('List of all devis'))
                
            <div class="col-md-3">
                <!-- Card -->
                <div class="card container-fluid rounded-4">
                    <div class="py-3 px-2">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h6 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        <span class="legend-circle-sm bg-danger"></span>
                                        @lang('messages.Total devis')
                                    </h6>

                                    <!-- Subtitle -->
                                    <h3 class="mb-0 fw-bold">
                                        {{ $total_devis }}
                                    </h3>
                                </div>

                                <span class="text-primary mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <hr class="text-muted mx-0">
                        <div class="row">
                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <!-- Title -->
                                    <p class="text-muted mb-1">
                                        @lang('messages.Validés')
                                    </p>
                                    <!-- Subtitle -->
                                    <h4 class="mb-0 fw-semibold">
                                        {{ $valid_devis }}
                                    </h4>
                                </div>
                                <div>
                                    <!-- Title -->
                                    <p class="text-muted mb-1">
                                        @lang('messages.Non Validés')
                                    </p>
                                    <!-- Subtitle -->
                                    <h4 class="mb-0 fw-semibold">
                                        {{ $invalid_devis }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- / .row -->
                    </div>
                </div>
            </div>

            @endif

        </div>

          <!-- Filter Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ url()->current() }}" class="row align-items-center gx-3 gy-2 m-0">
                            <div class="col-auto">
                                <span class="fw-bold text-muted text-uppercase d-flex align-items-center" style="font-size: 0.85rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-range me-2" viewBox="0 0 16 16">
                                      <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1zM1 9h4a1 1 0 0 1 0 2H1V9z"/>
                                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    Période :
                                </span>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm mb-0">
                                    <span class="input-group-text bg-light text-muted fw-bold border-end-0">Du</span>
                                    <input type="date" name="start_date" id="start_date" class="form-control border-start-0 ps-0" value="{{ $start_date }}">
                                </div>
                            </div>
                            <div class="col-auto d-none d-sm-block">
                                <span class="text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm mb-0">
                                    <span class="input-group-text bg-light text-muted fw-bold border-end-0">Au</span>
                                    <input type="date" name="end_date" id="end_date" class="form-control border-start-0 ps-0" value="{{ $end_date }}">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm px-3 rounded-pill fw-bold shadow-sm d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-filter me-1" viewBox="0 0 16 16">
                                      <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                    </svg> Filtrer
                                </button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ url()->current() }}" class="btn btn-light btn-sm px-3 rounded-pill fw-bold text-muted border shadow-sm d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-clockwise me-1" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                      <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                    </svg>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Charts Row -->
        <div class="row mt-4">
            <div class="col-lg-6 mb-4">
                <div class="card rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="card-title fw-bold text-muted text-uppercase mb-1" style="font-size: 1rem;">Chiffre d'Affaires Mensuel (MAD)</h5>
                                <small class="text-secondary d-block" style="font-size: 0.7em;">Du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} Au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small>
                            </div>
                            <div class="text-end bg-light rounded px-3 py-2 border">
                                <span class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Total sur la période</span>
                                <h5 class="fw-bold text-success mb-0">{{ number_format($total_ca_periode, 2, ',', ' ') }} <small class="text-muted" style="font-size: 0.7em;">MAD</small></h5>
                            </div>
                        </div>
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="caChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-muted text-uppercase mb-4">Nouveaux Clients Ajoutés <br><small class="text-secondary" style="font-size: 0.7em;">Du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} Au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small></h5>
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="clientsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-6 mb-4">
                <div class="card rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-muted text-uppercase mb-4">Évolution des Factures <br><small class="text-secondary" style="font-size: 0.7em;">Du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} Au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small></h5>
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="facturesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-muted text-uppercase mb-4">Évolution des Devis <br><small class="text-secondary" style="font-size: 0.7em;">Du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} Au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small></h5>
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="devisChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const months = @json($monthsList);
            
            // Reformat PHP arrays to Javascript Arrays preserving order 1-12
            const caData = Object.values(@json($caByMonth));
            const clientsData = Object.values(@json($clientsByMonth));
            const facturesData = Object.values(@json($facturesByMonth));
            const devisData = Object.values(@json($devisByMonth));

            // Chart 1: Chiffre d'Affaires
            const ctxCA = document.getElementById('caChart').getContext('2d');
            new Chart(ctxCA, {
                type: 'line', 
                data: {
                    labels: months,
                    datasets: [{
                        label: "Montant Facturé (MAD)",
                        data: caData,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });

            // Chart 2: Nouveaux Clients
            const ctxClients = document.getElementById('clientsChart').getContext('2d');
            new Chart(ctxClients, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Nouveaux Clients',
                        data: clientsData,
                        backgroundColor: 'rgba(153, 102, 255, 0.7)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });

            // Chart 3: Factures
            const ctxFactures = document.getElementById('facturesChart').getContext('2d');
            new Chart(ctxFactures, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Factures créées',
                        data: facturesData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });

            // Chart 4: Devis
            const ctxDevis = document.getElementById('devisChart').getContext('2d');
            new Chart(ctxDevis, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Devis créés',
                        data: devisData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });


        });
    </script>
@endsection
