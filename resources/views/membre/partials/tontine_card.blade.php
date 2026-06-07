@php
    $totalTours = $tontine->tours->count();
    $toursEffectues = $tontine->tours->where('statut', 'effectue')->count();
    $pourcentage = $totalTours > 0 ? round(($toursEffectues / $totalTours) * 100) : 0;

    if ($role == 'organisateur') {
        $roleBadge = '<span class="badge bg-primary ms-2">Organisateur</span>';
    } elseif ($role == 'coorganisateur') {
        $roleBadge = '<span class="badge bg-success ms-2">Co-organisateur</span>';
    } else {
        $roleBadge = '<span class="badge bg-secondary ms-2">Participant</span>';
    }
@endphp

<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h5 class="mb-0">{{ $tontine->nom ?? 'Sans nom' }}</h5>
            {!! $roleBadge !!}
        </div>
        <div class="card-body">
            <p><i class="fas fa-money-bill-wave text-success"></i> <strong>Montant :</strong>
                {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
            <p><i class="fas fa-users text-info"></i> <strong>Participants :</strong> {{ $tontine->nbr_personne }}</p>
            <p><i class="fas fa-user-tie text-dark"></i> <strong>Organisateur :</strong>
                {{ $tontine->organisateur->prenom ?? '' }} {{ $tontine->organisateur->nom ?? '' }}</p>

            <div class="mt-2">
                <p class="mb-1"><i class="fas fa-chart-line"></i> <strong>Progression des tours :</strong>
                    {{ $toursEffectues }}/{{ $totalTours }}</p>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%;"
                        aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">{{ $pourcentage }}%
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-sm btn-outline-primary"><i
                        class="fas fa-eye"></i> Détails</a>
                @if ($role != 'participant')
                    <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-sm btn-outline-warning"><i
                            class="fas fa-edit"></i> Gérer</a>
                    <a href="{{ route('tontines.participants.index', $tontine) }}"
                        class="btn btn-sm btn-outline-secondary"><i class="fas fa-users"></i> Participants</a>
                @endif
                <a href="{{ route('membre.cotiser.create', $tontine) }}" class="btn btn-sm btn-outline-success"><i
                        class="fas fa-hand-holding-usd"></i> Cotiser</a>
                <a href="{{ route('membre.paiement.form', $tontine) }}" class="btn btn-sm btn-outline-info"><i
                        class="fas fa-credit-card"></i> Paiement en ligne</a>
                <!-- Bouton demande d'urgence -->
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                    data-bs-target="#urgenceModal{{ $tontine->id }}">
                    <i class="fas fa-exclamation-triangle"></i> Besoin urgent
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de demande d'urgence pour cette tontine -->
<div class="modal fade" id="urgenceModal{{ $tontine->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('membre.urgence.demander', $tontine) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Demande d’urgence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Justification de l’urgence</label>
                        <textarea name="motif" class="form-control" rows="4"
                            placeholder="Décrivez pourquoi vous avez besoin de l’argent immédiatement..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Envoyer la demande</button>
                </div>
            </form>
        </div>
    </div>
</div>
