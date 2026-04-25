<div class="modal fade"  wire:ignore.self id="viewModal{{ $RecuDePaiement_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Recu De Paiement Nº {!! $RecuDePaiement['num']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $RecuDePaiement['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $RecuDePaiement['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($RecuDePaiement['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $RecuDePaiement["client"]['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $RecuDePaiement["client"]['nom'] !!}</td>
                        </tr>
                        
                        <tr>
                            <th>Objectifs</th>
                            <td>{!! $RecuDePaiement["objectif"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $RecuDePaiement["objectif"] !!}</td>
                        </tr>


                        <tr>
                            <th>Produits</th>
                        <td>
                            <ol class="">
                                
                            @foreach ($RecuDePaiement_article  as $da)
                            
                            <li class=" ">
                                {!! $da["designation"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $da["designation"] !!}</li>
                            @endforeach
                        </ol>
                        </td>
                        </tr>
                        <tr>
                            <th>Montant</th>
                            <td>{!! $RecuDePaiement["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $RecuDePaiement["montant"] !!} Dh</td>
                        </tr>
                    
                    {{-- =========================================================================== --}}
                
                @if ($RecuDePaiement["etatremise"]=="valeur")
                  
                    <tr>  
                            <th>Montant Remise</th>
                            <td>{{ $RecuDePaiement["remise"]  }} Dh</td>

                    </tr>
                    
                @elseif ($RecuDePaiement["etatremise"]=="porsantage")
                   
                    <tr> 
                        <th>Remise</th>
                        <td>{{$RecuDePaiement["remise"]}}%</td>
                    </tr>
                    <tr>
                        <th>Montant Remise</th>
                        <td>{{( $RecuDePaiement["remise"]/100)*$RecuDePaiement["montant"]  }} Dh</td>
                    </tr>

                @endif

            @if ($RecuDePaiement["tva"] === 'on')
                <tr>
                    <th>TVA</th>
                    <td>{{ $RecuDePaiement["taux"] }} %</td>
                </tr>
                <tr>
                    <th>Montant TVA</th>
                    <td>{{ ($RecuDePaiement["taux"] / 100) * $RecuDePaiement["montant"] }} Dh</td>
                </tr>
                
            @else
                <tr>
                    <th>TVA</th>
                    <td>Non inclus</td>
                </tr>
                
            @endif
            @if ($RecuDePaiement["tva"] === 'on' || $RecuDePaiement["etatremise"]!== 'off')
                
                <tr>
                        <th>Montant TTC</th>
                        
                @if ($RecuDePaiement["tva"] === 'on')

                    @if ($RecuDePaiement["etatremise"]=="porsantage")
                        <td>
                                    {{ 
                                $RecuDePaiement["montant"]
                                -
                                (( $RecuDePaiement["remise"]/100)*$RecuDePaiement["montant"]) 
                                +
                                (($RecuDePaiement["taux"] / 100) * $RecuDePaiement["montant"])  }} Dh
                        </td>
                        
                    @else
                        
                        <td>
                                    {{ 
                                $RecuDePaiement["montant"]
                                -
                                $RecuDePaiement["remise"]
                                +
                                (($RecuDePaiement["taux"] / 100) * $RecuDePaiement["montant"])  }} Dh
                        </td>

                    @endif
                @else
                        @if ($RecuDePaiement["etatremise"]=="porsantage")
                            
                        <td>{{ 
                        $RecuDePaiement["montant"]
                        -
                        (( $RecuDePaiement["remise"]/100)*$RecuDePaiement["montant"])   }} Dh</td>
                        @else
                            
                        <td>{{ 
                            $RecuDePaiement["montant"]
                            -
                            $RecuDePaiement["remise"]   }} Dh</td>

                        @endif


                @endif
                </tr>
            @endif
            
        {{-- ==================================================================== --}}
                        

                        <tr>
                            <th>delai</th>
                            <td>{{ $RecuDePaiement["delai"] }} {{ $RecuDePaiement["type"] ? "mois": "jours" }}</td>
                        </tr>

                        <tr>
                            <th>Etat</th>
                            <td>{!! $RecuDePaiement["etat"] ?  "<span class='badge rounded-pill badge-bg-primary'>Validé</span>" : "<span class='badge rounded-pill badge-bg-warning'>Non validé</span>" !!}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                @if (auth()->user()->can('update recu de paiement'))
                    <a href="{{ route('RecuDePaiement.edit', $RecuDePaiement_id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                 @endif
                @if (auth()->user()->can('imprimer recu de paiement'))
                    <a href="{{ route('RecuDePaiement.download', $RecuDePaiement_id) }}" target="_blink" class="btn btn-facture">
                        <i class="bi bi-file-earmark-text"></i> Imprimer
                    </a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
