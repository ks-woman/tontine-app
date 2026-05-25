<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Toutes les cotisations</title>
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
    <h1>Liste de toutes les cotisations</h1>
    <p>Généré le : {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Membre</th>
                <th>Tontine</th>
                <th>Montant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->id }}</td>
                    <td>{{ $cotisation->membre->prenom ?? '' }} {{ $cotisation->membre->nom ?? '' }}</td>
                    <td>{{ number_format($cotisation->tontine->montant_total ?? 0, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $cotisation->date->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total général</th>
                <th colspan="2">{{ number_format($total, 0, ',', ' ') }} FCFA</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Application de gestion de tontine - Document généré automatiquement
    </div>
</body>

</html>
