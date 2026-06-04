@extends('layouts.membre')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Mes tontines</h1>
                <hr>
            </div>
        </div>

        <!-- Tontines organisées -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="text-primary">Tontines que j'organise</h3>
                @if ($tontinesOrganisees->count() > 0)
                    <div class="row">
                        @foreach ($tontinesOrganisees as $tontine)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $tontine->nom ?? 'Sans nom' }}</h5>
                                        <p>Montant: {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                                        <p>Participants: {{ $tontine->nbr_personne }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-sm btn-info">Voir
                                            détails</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous n'organisez aucune tontine.</div>
                @endif
            </div>
        </div>

        <!-- Tontines co-organisées -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="text-success">Tontines où je suis co-organisateur</h3>
                @if ($tontinesCoOrganisees->count() > 0)
                    <div class="row">
                        @foreach ($tontinesCoOrganisees as $tontine)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $tontine->nom ?? 'Sans nom' }}</h5>
                                        <p>Montant: {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                                        <p>Organisateur: {{ $tontine->organisateur->prenom ?? '' }}
                                            {{ $tontine->organisateur->nom ?? '' }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-sm btn-info">Voir
                                            détails</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous n'êtes co-organisateur d'aucune tontine.</div>
                @endif
            </div>
        </div>

        <!-- Tontines où je participe -->
        <div class="row">
            <div class="col-12">
                <h3 class="text-warning">Tontines où je participe</h3>
                @if ($tontinesParticipants->count() > 0)
                    <div class="row">
                        @foreach ($tontinesParticipants as $tontine)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $tontine->nom ?? 'Sans nom' }}</h5>
                                        <p>Montant: {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                                        <p>Organisateur: {{ $tontine->organisateur->prenom ?? '' }}
                                            {{ $tontine->organisateur->nom ?? '' }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('tontines.show', $tontine) }}"
                                                class="btn btn-sm btn-info">Voir détails</a>
                                            <a href="{{ route('membre.cotiser.create', $tontine) }}"
                                                class="btn btn-sm btn-success">Cotiser</a>
                                            <a href="{{ route('membre.paiement.form', $tontine) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-credit-card"></i> Payer en ligne
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#urgenceModal{{ $tontine->id }}">
                                                Besoin urgent
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de justification pour l'urgence -->
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
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Envoyer la demande</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous ne participez à aucune tontine.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
