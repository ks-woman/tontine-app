@extends('layouts.membre')

@section('content')
    <div class="container-fluid">
        <!-- En-tête -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
        </div>

        <!-- Cartes statistiques -->
        <div class="row mb-4">
            <!-- Total cotisé -->
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total cotisé</h6>
                                <h2 class="mb-0">{{ number_format($totalCotise, 0, ',', ' ') }} FCFA</h2>
                            </div>
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participations -->
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Participations</h6>
                                <h2 class="mb-0">{{ $nbParticipations }}</h2>
                            </div>
                            <i class="fas fa-hand-holding-usd fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prochain tour (amélioré) -->
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Prochain tour</h6>
                                @if ($prochainTour)
                                    <h2 class="mb-0">Ordre {{ $prochainTour->ordre }}</h2>
                                    <p class="mb-0"><strong>Bénéficiaire :</strong>
                                        {{ $prochainBeneficiaire->prenom ?? '' }} {{ $prochainBeneficiaire->nom ?? '' }}</p>
                                    <p class="mb-0"><strong>Tontine :</strong> {{ $prochainTour->tontine->nom ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0"><strong>Montant à recevoir :</strong>
                                        {{ number_format($montantTour ?? 0, 0, ',', ' ') }} FCFA</p>
                                @else
                                    <p class="mb-0">Aucun tour planifié</p>
                                @endif
                            </div>
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique + Notifications -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Évolution de mes cotisations (12 mois)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="cotisationsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Notifications récentes</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $notif)
                            <div class="list-group-item {{ $notif->lue ? '' : 'bg-light' }}">
                                <strong>{{ $notif->titre }}</strong>
                                <p class="mb-0 small">{{ $notif->message }}</p>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="list-group-item">Aucune notification</div>
                        @endforelse
                        <div class="list-group-item text-center">
                            <a href="{{ route('membre.notifications') }}">Voir toutes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations personnelles et liens utiles -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Mon profil</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> {{ $membre->prenom }} {{ $membre->nom }}</p>
                        <p><strong>Email :</strong> {{ $membre->email }}</p>
                        <p><strong>Téléphone :</strong> {{ $membre->telephone }}</p>
                        <a href="{{ route('membre.profil.edit') }}" class="btn btn-sm btn-primary">Modifier mon profil</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Liens utiles</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('public.annonces') }}"> Voir les annonces</a></li>
                            <li><a href="{{ route('membre.mes_tontines') }}"> Mes tontines</a></li>
                            <li><a href="{{ route('membre.mes_cotisations') }}">Mes cotisations</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('cotisationsChart').getContext('2d');
            const data = @json($evolution);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.mois),
                    datasets: [{
                        label: 'Cotisations (FCFA)',
                        data: data.map(item => item.montant),
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
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
