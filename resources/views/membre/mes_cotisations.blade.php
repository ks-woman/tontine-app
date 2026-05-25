@extends('layouts.membre')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Mes cotisations</h1>
                <hr>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total cotisé</h5>
                        <h3>{{ number_format($total_cotise, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tontine</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Mode de paiement</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotisations as $cotisation)
                            <tr>
                                <td>{{ $cotisation->id }}</td>
                                <td>{{ $cotisation->tontine->nom ?? 'Sans nom' }}</td>
                                <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</br>
                                <td>{{ $cotisation->date->format('d/m/Y') }}</br>
                                <td>
                                    @if ($cotisation->mode_paiement == 'especes')
                                        <span class="badge bg-secondary">Espèces</span>
                                    @elseif($cotisation->mode_paiement == 'orange_money')
                                        <span class="badge bg-warning">Orange Money</span>
                                    @elseif($cotisation->mode_paiement == 'wave')
                                        <span class="badge bg-info">Wave</span>
                                    @else
                                        <span class="badge bg-primary">Free Money</span>
                                    @endif
                                    </br>
                                <td>
                                    @if ($cotisation->statut_paiement == 'confirme')
                                        <span class="badge bg-success">Confirmé</span>
                                    @elseif($cotisation->statut_paiement == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté</span>
                                    @endif
                                    </br>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune cotisation enregistrée.</br>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $cotisations->links() }}
            </div>
        </div>
    </div>
@endsection
