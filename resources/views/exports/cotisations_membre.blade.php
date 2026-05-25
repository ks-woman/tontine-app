<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cotisations de {{ $membre->prenom }} {{ $membre->nom }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        .info {
            margin-bottom: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h1>Cotisations de {{ $membre->prenom }} {{ $membre->nom }}</h1>

    <div class="info">
        <p><strong>Email :</strong> {{ $membre->email }}</p>
        <p><strong>Téléphone :</strong> {{ $membre->telephone }}</p>
        <p><strong>Date d'adhésion :</strong> {{ $membre->date_adhesion->format('d/m/Y') }}</p>
        <p><strong>Généré le :</strong> {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tontine</th>
                <th>Montant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->id }}</td>
                    <td>{{ number_format($cotisation->tontine->montant_total ?? 0, 0, ',', ' ') }} FCFA</br>
                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</br>
                    <td>{{ $cotisation->date->format('d/m/Y') }}</br>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th colspan="2">{{ number_format($total, 0, ',', ' ') }} FCFA</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Application de gestion de tontine - Document généré automatiquement
    </div>
</body>

</html>
