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
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('tontines.show', $tontine) }}"
                                                class="btn btn-sm btn-info">Voir détails</a>
                                            <a href="{{ route('membre.cotiser.create', $tontine) }}"
                                                class="btn btn-sm btn-success">Cotiser</a>
                                        </div>
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
