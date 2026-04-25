@extends('layouts.app')

@section('content')



        @if (auth()->user()->can('create devis'))
        <div class="d-flex py-2">
            <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
            <div class="p-2 justify-content-end">
                <a class="pull-right btn btn-primary"  href="{{ route('bon_sortie.create') }}">Ajouter
                    un bon de Sortie <i class="bi bi-plus-lg"></i>
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
                <th>N°</th>
                <th>Client</th>
              
                <th>ICE</th>
                <th>Telephone</th>

                <th>Taux</th>
                  <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bons as $bon)
                <tr>
                    <td>{{ $bon['num'] }}</td>
                    <td>{{ $bon['client']['nom'] }}</td>
                   
                    <td>{{ $bon['client']['ice'] ?? 'Client inconnu' }}</td>
           
                    <td>{{ $bon['client']['tel'] }}</td>
                
                  
                    <td>{{ number_format($bon->montant, 2, '.', '') }}</td>
                     <td>{{ \Carbon\Carbon::parse($bon->date)->format('d/m/Y') }}</td>
                   
                    <td>
                      <button type="button" wire:click.debounce.200ms="find({{ $bon['id'] }})" class="btn btn-info" title="Voir"
            style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $bon['id'] }}">
            <i class="fas fa-eye"></i>
        </button>
        @include('bon_sortie.show')
                     
                        <div class="d-inline-block">
                            <a href="{{ route('bon_sortie.edit', $bon->id) }}" class="btn btn-warning" title="Éditer"
                                style="padding: 3px 9px; font-size: 16px;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <form action="{{ route('bon_sortie.destroy', $bon->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Confirmer la suppression ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                         <a href="{{ route('bon_sortie.download', $bon->id) }}" target="_blank" class="btn btn-success" title="Télécharger"
                                      style="padding: 3px 9px; font-size: 17px;">
                                     <i class="fas fa-file-alt"></i>
            </a>
                    </td>
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
