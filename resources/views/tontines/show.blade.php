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
                <p><strong>Montant total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
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
                <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Retour</a>

                @can('gerer', $tontine)
                    <a href="{{ route('tontines.participants.index', $tontine) }}" class="btn btn-secondary">
                        <i class="fas fa-users"></i> Gérer les participants
                    </a>
                @endcan
            </div>
        </div>
    </div>
@endsection
