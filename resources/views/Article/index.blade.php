@extends('layouts.app')

@section('content')


<div class="d-flex py-2">
    <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
    <div class="p-2 justify-content-end">
     
        <!-- Bouton Ajouter une catégorie de produit -->
       <a class="btn btn-primary me-3" href="{{ route('categorieproduits.index') }}">
         <i class="bi bi-grid"></i> Catégorie Produit
       </a>
       <a class="btn btn-primary me-3" href="{{ route('marques.index') }}">
        <i class="bi bi-grid"></i> Marque
      </a>
       <a class="btn btn-primary me-3" href="{{ route('fournisseurs.index') }}">
        <i class="bi bi-grid"></i> Fournisseur
     </a>


        <!-- Bouton Ajouter un produit -->
        <a class="pull-right btn btn-primary me-2" href="{{ route('article.create') }}">
            Ajouter un produit <i class="bi bi-plus-lg"></i>
        </a>

    </div>
</div>


   
    <section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body p-3 overflow-x-scroll" id="contentSection">
                        <table id="datatable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('messages.Designation')</th>
                                    <th>@lang('messages.Détails')</th>
                                    
                                    <th>@lang('Prix ht')</th>
                                  
                                    <th>Categorie </th>
                                    <th>Marque </th>
                                    <th>Fournisseur</th>
                                    
                                    @if (auth()->user()->can('show one article')||auth()->user()->can('delete article')||auth()->user()->can('update article'))
                                        
                                        <th class="noExport">@lang('messages.Opération')</th>
                                    @endif    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Articles as $Article)
                                    <tr>
                                        <td>
                                            {{ $Article['designation'] }}
                                        </td>
                                        <td>
                                          
                                                    <?php
                                                    $firstLine1 = strtok($Article['Details'], "\n");
                                            
                                                    // Remove newline characters from the first line
                                                    $firstLine = str_replace("\n", "", $firstLine1);
                                                     
                                                    // Limit the first line to 100 characters
                                                    $truncatedFirstLine = strlen($Article['Details']) > strlen($firstLine) ? $firstLine. '...' : ($firstLine?$firstLine:"<i class='text-secondary'>Il n'y a pas de détails</i>");
                                                    // Output the truncated first line
                                                    echo ($truncatedFirstLine);
                                                ?>
                                        </td>
                                       
                                        <td>
                                            {{ $Article['prix'] }}
                                        </td>
                                   
                                        <td>
                                            {{ $Article->CategorieProduit?->categorie ?? 'Non défini'  }}
                                        </td>
                                        <td>
                                            {{ $Article->Marque?->nom ?? 'Non défini'  }}
                                        </td>
                                        <td>
                                            {{ $Article->Fournisseur?->nom ?? 'Non défini'  }}
                                        </td>
                                    @if (auth()->user()->can('show one article')||auth()->user()->can('delete article')||auth()->user()->can('update article'))
                                        <td>
                                            @livewire('article-component', ['id' => $Article['id']])
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

