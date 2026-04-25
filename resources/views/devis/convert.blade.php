


<div class="modal fade " wire:ignore.self id="convertModel{{ $devis_id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1" id="show">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Converte Devis to Facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <form action="{{ route('devis.converttoFacture',["id"=>$devis_id]) }}"  class="row g-3" method="POST" >
                        @csrf


                        <div class="col-md-6 mx-5">
                            <label for="inputPaiement{{ $devis_id }}" class="form-label">Méthode de paiement :</label>
                            <select class="form-select" name="paiement" id="inputPaiement{{ $devis_id }}">
                                <option value="" hidden>-- Séléctionner la méthode --</option>
                                @foreach ($paiements as $paiement)
                                    <option  value="{{ $paiement['id'] }}">{{ $paiement['methode'] }}</option>
                                @endforeach
                            </select>
                            
                        </div>


                        <div class="col-md-6 mx-5">
                            <label class="form-label">
                                <div class="form-check form-switch mb-0">
                                    <label class="form-check-label" for="typeMpaiy{{ $devis_id }}">Montant payé :</label>
                                    <input class="form-check-input" type="checkbox" role="switch"  name="typeMpaiy" id="typeMpaiy{{$devis_id}}" onchange="functionName({{$devis_id}})">
                                </div>
                            </label>
                            <input type="number"
                                class="form-control "
                                id="inputtypeMpaiy{{$devis_id}}" name="montantPaiy"
                                
                                placeholder="Veuillez saisir ici ..." disabled min="0"
                                step="0.001">
                        </div>

                       
                        {{-- @endpush --}}

                        <div class="col-md-12" hidden>
                            <label for="etat{{ $devis_id }}" class="form-label">Etat :</label>
                            <select class="form-select " id="etat{{ $devis_id }}"
                                name="etat">
                                <option value="" hidden>-- Séléctionner l'état --</option>
                                <option selected value="0">Impayée</option>
                                <option value="1">Payée</option>
                            </select>
                            
                        </div>

                        <div class="text-center mt-5">
                            <button type="button" class="btn btn-secondary order-last order-md-first"
                                data-bs-dismiss="modal">
                                <i class="bi bi-caret-left-fill"></i> Fermer
                            </button>
                            <button type="submit" class="btn btn-primary"
                                id="submit">Enregister</button>
                        </div>
                    </form>
                  </div>



                  

                

    </div>
</div>
</div>
    

<script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>

 <script>
    var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })


</script>
@if($errors->any())
    
    
    @error('paiement')
    <script>
         Toast.fire({
            icon: 'error',
            title: @json($message)
        })
    </script>
    @enderror
    
    @error('montantPaiy')
    <script>
         Toast.fire({
            icon: 'error',
            title: @json($message)
        })
    </script>
    @enderror

@endif
@if (session()->has('worning'))
    <script>
        Toast.fire({
        icon: 'warning',
        title: @json(session('worning'))
    })
    </script>
@endif

@if (session()->has('info'))
    
    <script>
        Toast.fire({
        icon: 'success',
        title: @json(session('info'))
    })
    </script>
@endif

<script>
    
    function functionName(devis_id){
    
    
    // console.log($('#typeMpaiy').prop("checked"));
    if ($('#typeMpaiy'+devis_id).prop("checked") == true) $('#inputtypeMpaiy'+devis_id).removeAttr('disabled')
    if ($('#typeMpaiy'+devis_id).prop("checked") == false) {
        $('#inputtypeMpaiy'+devis_id).attr('disabled', 'disabled')
        $('#inputtypeMpaiy'+devis_id).val(0)
    }
    $('#typeMpaiy'+devis_id).click(function() {
        if ($(this).prop("checked") == true) $('#inputtypeMpaiy'+devis_id).removeAttr('disabled')
        if ($(this).prop("checked") == false) {
            $('#inputtypeMpaiy'+devis_id).attr('disabled', 'disabled');
            $('#inputtypeMpaiy'+devis_id).val(0)
        }
    });
    }
    // End change input typeMpaiy
</script>