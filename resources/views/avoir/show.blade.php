@php
     $standardArticles = DB::table('avoir_article')
        ->where('avoir_id', $bon['id'])
        ->join('articles', 'avoir_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'avoir_article.quantite as quantite', 'avoir_article.prix_article as prix')
        ->get()
        ->toArray();

    $customArticles = DB::table('avoir_custom_articles')
        ->where('avoir_id', $bon['id'])
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();

    $bonArticles = array_merge($standardArticles, $customArticles);
@endphp
<div class="modal fade"  wire:ignore.self id="viewModal{{ $bon['id'] }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Avoir Nº {!! $bon['num']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $bon['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $bon['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($bon['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $bon["client"]['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $bon["client"]['nom'] !!}</td>
                        </tr>
                        

                        <tr>
                            <th>Produits</th>
                        <td>
                            <ol class="">
                                
                            @foreach ($bonArticles  as $da)
                            
                           <li class="">{{ $da->produit  }}</li>
                            @endforeach
                        </ol>
                        </td>
                        </tr>
                        <tr>
                            <th>Montant</th>
                            <td>{!! $bon["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($bon["montant"], 2, '.', '') !!} Dh</td>
                        
                    {{-- =========================================================================== --}}
      @if ($bon["etatremise"] == "montant")
    <tr>  
        <th>Montant Remise</th>
        <td>{{ number_format($bon["remise"], 2, '.', '') }} Dh</td>
    </tr>
@elseif ($bon["etatremise"] == "pourcentage")
    <tr> 
        <th>Remise</th>
        <td>{{ number_format($bon["remise"], 2, '.', '') }}%</td>
    </tr>
    <tr>
        <th>Montant Remise</th>
        <td>{{ number_format(($bon["remise"] / 100) * $bon["montant"], 2, '.', '') }} Dh</td>
    </tr>
@endif

@if ($bon["tva"] === 'on' || $bon["tva"] == 1)
    <tr>
        <th>TVA</th>
        <td>20 %</td>
    </tr>
    <tr>
        <th>Montant TVA</th>
        <td>
            @if ($bon["etatremise"] == "pourcentage")
                {{ number_format((20 / 100) * ($bon["montant"] - ($bon["remise"] / 100) * $bon["montant"]), 2, '.', '') }} Dh
            @elseif ($bon["etatremise"] == "montant")
                {{ number_format((20 / 100) * ($bon["montant"] - $bon["remise"]), 2, '.', '') }} Dh
            @else
                {{ number_format((20 / 100) * $bon["montant"], 2, '.', '') }} Dh
            @endif
        </td>
    </tr>
@else
    <tr>
        <th>TVA</th>
        <td>Non inclus</td>
    </tr>
@endif

<tr>
    <th>Montant TTC</th>
    <td>
        @php
            $tvaFactor = ($bon["tva"] === 'on' || $bon["tva"] == 1) ? 0.2 : 0;
            $montant = (float)$bon["montant"];
            $remiseValue = (float)$bon["remise"];
            $ttc = 0;
            
            $base = $montant;
            if ($bon["etatremise"] == "pourcentage") {
                $base = $montant - ($remiseValue / 100 * $montant);
            } elseif ($bon["etatremise"] == "montant") {
                $base = $montant - $remiseValue;
            }
            
            $ttc = $base + ($base * $tvaFactor);
        @endphp

        {{ number_format($ttc, 2, '.', '') }} Dh
    </td>
</tr>

                        
                    {{-- ==================================================================== --}}
                     

                        <tr>
                            <th>Etat</th>
                            <td>{!! $bon["etat"] ?  "<span class='badge rounded-pill badge-bg-primary'>Validé</span>" : "<span class='badge rounded-pill badge-bg-warning'>Non validé</span>" !!}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update bon'))
                
                    <a href="{{ route('avoir.edit', $bon['id']) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                    @endif

                    @if (auth()->user()->can('imprimer bon'))
                    <a href="{{ route('avoir.download', $bon['id']) }}" target="_blink" class="btn btn-facture">
                        <i class="bi bi-file-earmark-text"></i> Imprimer
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
