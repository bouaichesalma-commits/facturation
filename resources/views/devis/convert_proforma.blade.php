<div class="modal fade" wire:ignore.self id="convertFP{{ $devis_id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Converte Devis to Facture Proforma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('devis.converttoFactureProforma', ['id' => $devis_id]) }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6 mx-5">
                        <label for="inputPaiement{{ $devis_id }}" class="form-label">Méthode de paiement :</label>
                        <select class="form-select" name="paiement" id="inputPaiement{{ $devis_id }}">
                            <option value="" hidden>-- Séléctionner la méthode --</option>
                            @foreach ($paiements as $paiement)
                                <option value="{{ $paiement['id'] }}">{{ $paiement['methode'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mx-5">
                        <label class="form-label">
                            <div class="form-check form-switch mb-0">
                                <label class="form-check-label">Montant payé :</label>
                                <input class="form-check-input toggle-montant"
                                       type="checkbox"
                                       role="switch"
                                       data-devis-id="{{ $devis_id }}">
                            </div>
                        </label>
                        <input type="number"
                               class="form-control montant-input"
                               name="montantPaiy"
                               data-devis-id="{{ $devis_id }}"
                               placeholder="Veuillez saisir ici ..."
                               disabled
                               min="0"
                               step="0.001">
                    </div>

                    <div class="col-md-12" hidden>
                        <label class="form-label">Etat :</label>
                        <select class="form-select" name="etat">
                            <option value="" hidden>-- Séléctionner l'état --</option>
                            <option selected value="0">Impayée</option>
                            <option value="1">Payée</option>
                        </select>
                    </div>

                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-caret-left-fill"></i> Fermer
                        </button>
                        <button type="submit" class="btn btn-primary">Enregister</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll('.toggle-montant');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const devisId = this.dataset.devisId;
                const input = document.querySelector('.montant-input[data-devis-id="' + devisId + '"]');

                if (this.checked) {
                    input.removeAttribute('disabled');
                } else {
                    input.setAttribute('disabled', 'disabled');
                    input.value = 0;
                }
            });
        });
    });
</script>
