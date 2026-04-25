@extends('layouts.app')

@section('content')
@if (auth()->user()->can('create client'))
<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
    <div class="p-2 justify-content-end">
        <a class="pull-right btn btn-primary" href="{{route('client.create')}}">Ajouter
            un client <i class="bi bi-plus-lg"></i>
        </a>
    </div>
</div>

@endif
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                        <table id="datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    
                                    <th >Nom</th>
                                    <th>ICE</th>
                                    <th>Ville</th>
                                    <th>Téléphone</th>
                                    
                                    <th>Devis</th>
                                    <th>Date</th>
                                    <th>Factures</th>
                                    @if (auth()->user()->can('show one client')||auth()->user()->can('delete client')||auth()->user()->can('update client'))
                                        
                                        <th class="noExport">Opération</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                        <tr>
                                            <td>
                                                {{ $client['nom'] }}
                                            </td>
                                            <td>
                                                {{ $client['ice'] }}
                                            </td>
                                            <td>
                                                {{ $client['adresse'] }}
                                            </td>
                                            <td>
                                                {{ $client['tel'] }}
                                            </td>
                                           
                                             <td>{{ $client->devis_count }}</td> 
                                              <td>{{ date('d/m/Y', strtotime($client['created_at']))}}</td> 
                                            <td>{{ $client->factures_count }}</td>
                                            
                                    @if (auth()->user()->can('show one client')||auth()->user()->can('delete client')||auth()->user()->can('update client'))
                                        
                                            <td>
                                                @livewire('client-component', ['id' => $client['id']])
                                            </td>
                                    
                                    @endif
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
