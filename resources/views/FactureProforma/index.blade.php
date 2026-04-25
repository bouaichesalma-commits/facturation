@extends('layouts.app')

@section('content')

    @if (auth()->user()->can('create facture proformas'))
    <div class="d-flex py-2">
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
        <div class="p-2 justify-content-end">
            <a class="pull-right btn btn-primary" href="{{route('factureProforma.create')}}">Ajouter
                une facture <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
    @endif
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    

                    <div class="card-body overflow-x-scroll" id="contentSection">
                        
                        <table id="datatable" class="table table-hover no-client-paginate" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Etat</th>
                                    <th>Montant paid</th>
                                    <th>Date</th>
                             @if (auth()->user()->can('show one facture proformas')||auth()->user()->can('update facture proformas')||auth()->user()->can('imprimer facture proformas')||auth()->user()->can('delete facture proformas'))
                                    <th class="noExport">Opération</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factureProformas as $facture)
                                    <tr>
                                        <td>
                                            {{ $facture['num'] }}
                                        </td>
                                        <td>
                                            {{ $facture['client']['nom'] }}
                                        </td>
                                        <td>
                                            {{ number_format($facture['montant'], 2, '.', '') }}
                                        </td>
                                        <td>
                                            {!! $facture['etat'] ? "<span class='badge rounded-pill badge-bg-primary'>Payée</span>" : "<span class='badge rounded-pill badge-bg-warning'>Impayée</span>" !!}
                                        </td>
                                          <td>
                                            {{ number_format($facture->reglements->sum('montant'), 2, '.', '') }}
                                        </td>
                                        <td>
                                            {{ date_format(date_create($facture['date']), 'd-m-Y') }}
                                        </td>
                             @if (auth()->user()->can('show one facture proformas')||auth()->user()->can('update facture proformas')||auth()->user()->can('imprimer facture proformas')||auth()->user()->can('delete facture proformas'))
                                        <td>
                                            @livewire('facture-proforma-component', ['id' => $facture['id']])
                                        </td>
                                    @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $factureProformas->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
