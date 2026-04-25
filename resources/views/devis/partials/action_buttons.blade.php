<div class="d-flex w-100 flex-column">

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
             Actions
        </button>  

         <ul class="dropdown-menu">

            @if(auth()->user()->can('convert devis'))
               <li>
                   <a class="dropdown-item fw-semibold"  wire:navigate href="{{ route('devis.update', $devis->id) }}">
                        Modifier la devis 
                        <i class="fs-5 pb-0 ms-1 mb-0 bi bi-file-earmark-break text-danger"></i>
                    </a>
               </li>
            @endif


            @if (auth()->user()->can('update devis'))
                <li>
                    <a class="dropdown-item fw-semibold"  wire:navigate href="{{ route('devis.edit', $devis->id) }}">
                        Modifier 
                       <i class="fs-5 pb-0 ms-1 mb-0 bi bi-pencil-square text-primary"></i>
                    </a>
                </li>
            @endif
             @if (auth()->user()->can('show one devis'))
                <li>
                    <a class="dropdown-item fw-semibold"  wire:navigate href="{{ route('devis.show', $devis->id) }}">
                        Afficher <i class="fs-5 pb-0 ms-1 mb-0 bi bi-eye text-primary"></i>
                    </a>
                </li>
                @endif
                @if (auth()->user()->can('delete devis'))
                <li>
                     <button type="button" class="dropdown-item fw-semibold" 
                        data-bs-toggle="modal" data-bs-target="#deleteDeivs-{{ $devis->id }}">
                           Supprimer<i class="fs-5 pb-0 ms-1 mb-0 bi bi-trash3 text-danger"></i>
                        </button>
                </li>
                @endif
                @if (auth()->user()->can('imprimer devis'))
                <li>
                    <a class="dropdown-item fw-semibold"  wire:navigate href="{{ route('devis.download', $devis->id) }}" target="_blank">
                        Imprimer  
                       <i class="fs-5 pb-0 ms-1 mb-0 bi bi-printer text-success"></i>
                    </a>
                </li>
                @endif
         </ul>


    </div>
</div>

 <!-- Modal Structure -->
    <div wire:ignore.self class="modal fade" id="deleteDeivs-{{ $devis->id }}" tabindex="-1" aria-labelledby="deleteLabel-{{ $devis->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel-{{ $devis->id }}">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer le Devis numéro : <span class="fw-bold">{{ $devis->num }}</span> ?
                </div>
                <!-- Need to replace Livewire with explicit standard Laravel delete syntax for datatable button here -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('devis.destroy', $devis->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
