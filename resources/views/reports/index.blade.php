@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Rapports</h2>

        <form method="GET" action="{{ route('reports.index') }}">
            <label for="year">Choisir l'année:</label>
            <select name="year" id="year" onchange="this.form.submit()">
                @for ($i = 2010; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
        
        <div class="report">
            <h1 style="text-align: center">Rapport Total Du Montants :</h1>
            <h2>Année {{ $year }}</h2>
        
            <table border="1" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>Mois - Année</th>
                        <th>Montant (Factures + Devis)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyData as $data)
                        <tr>
                            <td>{{ $data['month'] }}</td>
                            <td>د.م. {{ number_format($data['amount'], 2, '.', ' ') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Montant Total</strong></td>
                        <td><strong>د.م. {{ number_format($totalAmount, 2, '.', ' ') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
    </div>
@endsection
