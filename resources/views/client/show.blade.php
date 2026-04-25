<div class="modal fade" wire:ignore.self id="viewModal{{ $client_id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-center">Client : {!! $client['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $client['nom'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Email</th>
                            <td>{!! $client['email'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $client['email'] !!}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{!! $client['tel']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $client['tel']!!}</td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td>{!! $client['adresse']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $client['adresse']!!}</td>
                        </tr>
                        <tr>
                            <th>ICE</th>
                            <td>{!! $client['ice']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $client['ice']!!}</td>
                        </tr>
                    </tbody>
                </table>
                <div
                    class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first"
                        data-bs-dismiss="modal"><i class="bi bi-caret-left-fill"></i>
                        Fermer</button>
                        
                        
                </div>

            </div>
        </div>
    </div>
</div>
