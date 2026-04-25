@extends('layouts.app')

@section('content')

                    @if (auth()->user()->can('create recu de paiement'))
                        <div class="d-flex py-2">
                            <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
                            <div class="p-2 justify-content-end">
                                <a class="pull-right btn btn-primary" href="{{route('RecuDePaiement.create')}}">Ajouter
                                    un Reçu de paiement <i class="bi bi-plus-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endif
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body overflow-x-scroll" id="contentSection">
                        <table id="datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Objectif</th>
                                    <th>Etat</th>
                                    <th>Date</th>
                                    @if (auth()->user()->can('show one recu de paiement')||auth()->user()->can('update recu de paiement')||auth()->user()->can('delete recu de paiement')||auth()->user()->can('imprimer recu de paiement'))
                                        <th class="noExport">Opération</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($RecuDePaiements as $RecuDePaiement)
                                    <tr>
                                        <td>
                                            {{ $RecuDePaiement['num'] }} 
                                        </td>
                                        <td>
                                            {{ $RecuDePaiement['client']['nom'] }}
                                        </td>
                                        <td>
                                            {{ $RecuDePaiement['objectif'] }}
                                        </td>
                                        <td>
                                            {!! $RecuDePaiement['etat'] ? '<span class="badge badge-bg-primary rounded-pill">Validé</span>' : '<span class="badge badge-bg-warning rounded-pill">Non validé</span>' !!}
                                        </td>
                                        <td>
                                            {{ date_format(date_create($RecuDePaiement['date']), 'd/m/Y') }}
                                        </td>
                                    @if (auth()->user()->can('show one recu de paiement')||auth()->user()->can('update recu de paiement')||auth()->user()->can('delete recu de paiement')||auth()->user()->can('imprimer recu de paiement'))
                                        <td>
                                            @livewire('recu-de-paiement-component', ['id' => $RecuDePaiement['id']])
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
