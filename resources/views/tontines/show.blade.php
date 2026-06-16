@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Détails de la tontine</h3>
            </div>
            <div class="card-body">
                <p><strong>ID :</strong> {{ $tontine->id }}</p>
                <p><strong>Nom :</strong> {{ $tontine->nom ?? 'Sans nom' }}</p>
                <p><strong>Description :</strong> {{ $tontine->description ?? 'Non renseignée' }}</p>
                <p><strong>Durée :</strong> {{ $tontine->duree_mois ?? $tontine->nbr_personne }} mois</p>
                <p><strong>Date de début :</strong>
                    {{ $tontine->date_debut ? $tontine->date_debut->format('d/m/Y') : 'Non définie' }}</p>
                <p><strong>Date de fin :</strong>
                    {{ $tontine->date_fin ? $tontine->date_fin->format('d/m/Y') : 'Non définie' }}</p>
                <p><strong>Fréquence :</strong> {{ ucfirst($tontine->frequence) }}</p>
                <p><strong>Montant total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                <p><strong>Montant cotisation :</strong>
                    {{ $tontine->montant_cotisation ? number_format($tontine->montant_cotisation, 0, ',', ' ') . ' FCFA' : 'Non défini' }}
                </p>
                <p><strong>Nombre de personnes :</strong> {{ $tontine->nbr_personne }}</p>
                <p><strong>Taux :</strong> {{ $tontine->taux ?? 'Non défini' }} %</p>
                <p><strong>Montant du taux :</strong>
                    {{ $tontine->montant_taux ? number_format($tontine->montant_taux, 0, ',', ' ') . ' FCFA' : 'Non défini' }}
                </p>
                <p><strong>Organisateur :</strong> {{ $tontine->organisateur->prenom ?? '' }}
                    {{ $tontine->organisateur->nom ?? '' }}</p>
                <p><strong>Date création :</strong> {{ $tontine->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="card-footer">
                @can('update', $tontine)
                    <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">Modifier</a>
                    <a href="{{ route('admin.tontines.statistiques', $tontine) }}" class="btn btn-info">
                        <i class="fas fa-chart-pie"></i> Statistiques
                    </a>
                    <form action="{{ route('tontines.tirage-au-sort', $tontine) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info"
                            onclick="return confirm('Tirer au sort l’ordre des bénéficiaires ?')">
                            <i class="fas fa-random"></i> Tirage au sort
                        </button>
                    </form>
                    <form action="{{ route('admin.tontines.valider-tour', $tontine) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Valider le prochain tour ?')">
                            <i class="fas fa-check-circle"></i> Valider le prochain tour
                        </button>
                    </form>
                @endcan
                <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
