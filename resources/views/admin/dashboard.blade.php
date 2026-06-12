@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Cartes statistiques (version modernisée) -->
        <div class="row g-4 mb-4">
            <!-- Carte Membres -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small">Membres</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['total_membres'] }}</h2>
                                <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+{{ $stats['membres_mois'] }}
                                    ce mois</small>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Tontines -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small">Tontines</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['total_tontines'] }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hand-holding-usd fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Tours -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small">Tours</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['total_tours'] }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar-alt fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Total Cotisé -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small">Total cotisé</h6>
                                <h2 class="mb-0 fw-bold">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }} FCFA
                                </h2>
                                <small class="text-success"><i
                                        class="fas fa-arrow-up me-1"></i>+{{ number_format($stats['cotisations_mois'], 0, ',', ' ') }}
                                    FCFA ce mois</small>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique évolution cotisations -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Évolution des cotisations (12 mois)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="evolutionChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Top 5 cotisants</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($top_membres as $membre)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $membre->membre->prenom ?? 'N/A' }} {{ $membre->membre->nom ?? '' }}
                                    <span class="badge bg-primary rounded-pill">
                                        {{ number_format($membre->total_cotise, 0, ',', ' ') }} FCFA
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières activités -->
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Dernières cotisations</h5>
                        <a href="{{ route('admin.export.cotisations') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Exporter tout
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Tontine</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dernieres_cotisations as $cotisation)
                                    <tr>
                                        <td>{{ $cotisation->membre->prenom ?? 'N/A' }}
                                            {{ $cotisation->membre->nom ?? '' }}</br>
                                        <td>{{ $cotisation->tontine->montant_total ?? 'N/A' }} FCFA</br>
                                        <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</br>
                                        <td>{{ $cotisation->date->format('d/m/Y') }}</br>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tontines récentes</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach ($tontines_actives as $tontine)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</strong><br>
                                        <small>{{ $tontine->nbr_personne }} participants</small>
                                    </div>
                                    <span class="badge bg-info">{{ $tontine->organisateur->prenom ?? 'N/A' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('evolutionChart').getContext('2d');
            const data = @json($evolution);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.mois),
                    datasets: [{
                        label: 'Cotisations (FCFA)',
                        data: data.map(item => item.total),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
