@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des marques</h1>

    <a href="{{ route('marques.create') }}" class="btn btn-primary mb-3">Ajouter une marque</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
             
                <th>ID</th>
                <th>Nom</th>
                <th>Action</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($marques as $marque)
            <tr>
                
                <td>{{ $marque->id }}</td>
                <td>{{ $marque->nom }}</td>
                
                <td>
                   
              

                    <a href="{{ route('marques.edit', $marque->id) }}" class="btn btn-warning" title="Éditer" style=" padding: 3px 9px;  font-size: 16px;">
                        <i class="fas fa-edit" ></i>
                    </a>
                    <form action="{{ route('marques.destroy', $marque->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Supprimer" style=" padding: 3px 9px;  font-size: 16px;">
                            <i class="fas fa-trash" ></i>
                        </button>
                    </form>
                  
                    
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
