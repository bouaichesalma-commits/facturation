<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bon de Commande Fournisseur {{ $numero }} - {{ $fournisseur }}</title>
    @include('partials.pdf_styles')
</head>
<body>
    @include('partials.pdf_footer')
    <div class="container">
        {{-- Logo Section --}}
        <div style="margin-bottom: 25pt;">
            @if(!empty($agence->logo))
                <img src="{{ public_path($agence->logo) }}" style="height: 60pt; width: auto;" alt="Logo">
            @else
                <img src="{{ public_path('img/logo.png') }}" style="height: 60pt; width: auto;" alt="Logo">
            @endif
        </div>

        {{-- Header Section (Exact match to download.blade.php) --}}
        <div style="margin-bottom: 25pt;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 48%; vertical-align: middle; padding: 0;">
                        <div style="border: 1.5pt solid #000; border-radius: 10pt; padding: 10pt; height: 35pt; text-align: center; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 16pt; font-weight: bold;">BON DE COMMANDE :<br>{{ $numero }}</span>
                        </div>
                    </td>
                    <td style="width: 4%;"></td>
                    <td style="width: 48%; vertical-align: middle; padding: 0;">
                        <div style="border: 1.5pt solid #000; border-radius: 10pt; padding: 10pt; height: 35pt; text-align: center; display: flex; align-items: center; justify-content: center;">
                            @if($fournisseur !== 'Inconnu' && $fournisseur !== null)
                                <span style="font-size: 16pt; font-weight: bold; text-transform: uppercase;">{{ $fournisseur }}</span>
                            @endif
                            @if($fournisseur !== 'Inconnu' && !empty($ice))
                                <br><span style="font-size: 11pt; font-weight: bold;">ICE : {{ $ice }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; border-collapse: collapse; margin-top: 10pt;">
                <tr>
                    <td style="width: 52%;"></td>
                    <td style="width: 48%; font-size: 11pt; padding-left: 10pt;">
                        @if($fournisseur !== 'Inconnu' && !empty($adresse))
                            <b>Ville :</b> {{ $adresse }}<br>
                        @endif
                        @if($fournisseur !== 'Inconnu' && !empty($tel))
                            <b>Télephone :</b> {{ $tel }}<br>
                        @endif
                        @if($fournisseur !== 'Inconnu' && !empty($email))
                            <b>Email :</b> {{ $email }}<br>
                        @endif
                    </td>
                </tr>
            </table>

            <table style="width: 100%; border-collapse: collapse; margin-top: 40pt;">
                <tr>
                    <td style="width: 52%;"></td>
                    <td style="width: 48%; font-size: 11pt; padding-left: 10pt;">
                        <b>Casablanca le, </b> {{ $date }}
                    </td>
                </tr>
            </table>
        </div>

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 8%;">N°</th>
                    <th style="width: 52%; text-align: left; padding-left: 10pt;">Désignation</th>
                    <th style="width: 10%;">Qté</th>
                    <th style="width: 15%;">P.U</th>
                    <th style="width: 15%;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $index => $article)
                    @if(!$loop->last)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="designation">
                                {{ $article->produit }}
                            </td>
                            <td>{{ $article->quantite }}</td>
                            <td>{{ number_format($article->prix, 2, ',', ' ') }}</td>
                            <td>{{ number_format($article->prix * $article->quantite, 2, ',', ' ') }}</td>
                        </tr>
                    @else
                        <tr style="page-break-inside: avoid !important;">
                            <td colspan="5" style="padding: 0; border: none !important;">
                                <table class="nested-table">
                                    <tr>
                                        <td style="width: 8%;">{{ $index + 1 }}</td>
                                        <td class="designation" style="width: 52%;">
                                            {{ $article->produit }}
                                        </td>
                                        <td style="width: 10%;">{{ $article->quantite }}</td>
                                        <td style="width: 15%;">{{ number_format($article->prix, 2, ',', ' ') }}</td>
                                        <td style="width: 15%;">{{ number_format($article->prix * $article->quantite, 2, ',', ' ') }}</td>
                                    </tr>
                                    @php
                                        $totalsRows = 2; // HT and TTC
                                        if($total_Remise > 0) $totalsRows++;
                                        if($total_tva > 0) $totalsRows++;
                                    @endphp
                                    {{-- Totals --}}
                                    <tr>
                                        <td colspan="2" rowspan="{{ $totalsRows }}" style="vertical-align: top; border-left: none !important; border-bottom: none !important; border-right: 1pt solid #000; border-top: 1pt solid #000;">
                                            <div class="signature-wrapper">
                                                @if(!empty($agence->signature))
                                                    <img src="{{ public_path($agence->signature) }}" class="sig-img" alt="Signature">
                                                @endif
                                                @if(!empty($agence->cachet))
                                                    <img src="{{ public_path($agence->cachet) }}" class="cac-img" alt="Cachet">
                                                @endif
                                            </div>
                                        </td>
                                        <td colspan="2" style="font-weight: bold; text-align: center; text-transform: uppercase; border-top: 1pt solid #000;">TOTAL HT</td>
                                        <td style="font-weight: bold; text-align: center; border-top: 1pt solid #000;">{{ number_format($total_ht, 2, ',', ' ') }}</td>
                                    </tr>
                                    @if($total_Remise > 0)
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; text-align: center; text-transform: uppercase;">REMISE</td>
                                        <td style="font-weight: bold; text-align: center;">{{ number_format($total_Remise, 2, ',', ' ') }}</td>
                                    </tr>
                                    @endif
                                    @if($total_tva > 0)
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; text-align: center; text-transform: uppercase;">TVA 20%</td>
                                        <td style="font-weight: bold; text-align: center;">{{ number_format($total_tva, 2, ',', ' ') }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; text-align: center; text-transform: uppercase;">TOTAL TTC</td>
                                        <td style="font-weight: bold; text-align: center;">{{ number_format($total_ttc, 2, ',', ' ') }}</td>
                                    </tr>
                                    {{-- Stock Sentence as footnote row --}}
                                    <tr>
                                        <td colspan="5" class="table-footnote">
                                            Les tarifs ci-dessus sont valables jusqu’à épuisement des stocks.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>



    </div>
</body>
</html>
