@extends('layouts.app')

@section('content')
        @if (auth()->user()->can('create offre commerciale'))
            <div class="d-flex py-2">
                <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
                <div class="p-2 justify-content-end">
                    <a class="pull-right btn btn-primary" href="{{route('offreCommerciale.create')}}">Ajouter
                        un Offre Commerciale <i class="bi bi-plus-lg"></i>
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
                                    <th>num</th>
                                    <th>Objectif</th>
                                    @if (auth()->user()->can('show one offre commerciale')||auth()->user()->can('update offre commerciale')||auth()->user()->can('imprimer offre commerciale')||auth()->user()->can('delete offre commerciale'))
                                        <th class="noExport">Opération</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($OffreCommerciales as $key =>$OffreCommerciale)
                                    <tr>
                                        <th>{{$key+1}}</th>
                                        <td>
                                            {{ $OffreCommerciale['objectif'] }}
                                        </td>
                                    @if (auth()->user()->can('show one offre commerciale')||auth()->user()->can('update offre commerciale')||auth()->user()->can('imprimer offre commerciale')||auth()->user()->can('delete offre commerciale'))
                                        <td>
                                            
                                            @livewire('offre-commerciale-component', ['id' => $OffreCommerciale['id']])
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
