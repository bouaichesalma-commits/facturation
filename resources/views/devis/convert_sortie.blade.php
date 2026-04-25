<div wire:ignore.self class="modal fade" id="convertBonSortieModel{{ $devis_id }}" tabindex="-1" aria-labelledby="convertBonLabel{{ $devis_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('devis.convert.bon.sortie', $devis_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="convertBonLabel{{ $devis_id }}">Confirmer la conversion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment convertir ce devis en bon de Sortie ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Confirmer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
