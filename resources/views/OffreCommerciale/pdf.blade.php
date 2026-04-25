<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Offre Commerciale {{ $numero }}</title>
    @include('partials.pdf_styles')
</head>
<body>
    <div class="container">
        {{-- Logo Section --}}
        <div style="margin-bottom: 25pt;">
            @if(!empty($agence->logo))
                <img src="{{ public_path($agence->logo) }}" style="height: 60pt; width: auto;" alt="Logo">
            @else
                <img src="{{ public_path('img/logo.png') }}" style="height: 60pt; width: auto;" alt="Logo">
            @endif
        </div>

        {{-- Meta Row (Document and Client) --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25pt;">
            <tr>
                <td style="width: 48%; border: 1pt solid #000; border-radius: 10pt; padding: 10pt; text-align: center; vertical-align: middle;">
                    <span style="font-size: 16pt; font-weight: bold;">OFFRE COMMERCIALE : {{ $numero }}</span>
                </td>
                <td style="width: 4%;"></td> {{-- Gap --}}
                <td style="width: 48%; border: 1pt solid #000; border-radius: 10pt; padding: 10pt; text-align: center; vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold; text-transform: uppercase;">A L'ATTENTION DE :</div>
                    <div style="font-size: 11pt; margin-top: 5pt; font-weight: bold;">{{ $client }}</div>
                </td>
            </tr>
        </table>

        {{-- Date Section --}}
        <div style="text-align: right; margin-bottom: 12pt; font-weight: bold; font-size: 11pt;">
            Casablanca le, {{ $date }}
        </div>

        {{-- Subject --}}
        @if($objet)
        <div style="margin-bottom: 15pt; font-size: 12pt;">
            <strong>Objet :</strong> {{ $objet }}
        </div>
        @endif

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 8%;">N°</th>
                    <th style="width: 72%; text-align: left; padding-left: 10pt;">Désignation</th>
                    <th style="width: 20%;">Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $index => $article)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="designation">
                        {{ $article->designation ?? $article->produit }}
                    </td>
                    <td>{{ $article->pivot->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Signature Section (Simplified for Proposals) --}}
        <div style="margin-top: 30pt; font-size: 11pt;">
            Nous restons à votre entière disposition pour toute information complémentaire.
        </div>

        {{-- Signatures --}}
        <div class="signature-container">
            @if(!empty($agence->signature))
                <img src="{{ public_path($agence->signature) }}" class="signature-img" alt="Signature">
            @endif
            @if(!empty($agence->cachet))
                <img src="{{ public_path($agence->cachet) }}" class="cachet-img" alt="Cachet">
            @endif
        </div>

        {{-- Unified Footer --}}
        @include('partials.pdf_footer')

    </div>
</body>
</html>
