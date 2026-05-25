@extends('layouts.membre')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">{{ $annonce->titre }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Description</h5>
                                <p class="text-justify">{{ $annonce->description }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box bg-light p-3 rounded text-center">
                                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2 d-block"></i>
                                    <strong>Durée</strong>
                                    <p class="mb-0">{{ $annonce->duree_mois }} mois</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light p-3 rounded text-center">
                                    <i class="fas fa-users fa-2x text-success mb-2 d-block"></i>
                                    <strong>Participants</strong>
                                    <p class="mb-0">{{ $annonce->nombre_personnes }} personnes</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light p-3 rounded text-center">
                                    <i class="fas fa-money-bill-wave fa-2x text-warning mb-2 d-block"></i>
                                    <strong>Cotisation mensuelle</strong>
                                    <p class="mb-0">{{ number_format($annonce->montant_cotisation, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light p-3 rounded text-center">
                                    <i class="fas fa-tag fa-2x text-info mb-2 d-block"></i>
                                    <strong>Statut</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-success">Active</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($annonce->date_limite)
                            <div class="alert alert-warning mt-4">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Date limite :</strong> {{ $annonce->date_limite->format('d/m/Y') }} - Inscriptions
                                closes après cette date.
                            </div>
                        @endif

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            <strong>Montant total à cotiser :</strong>
                            {{ number_format($annonce->montant_cotisation * $annonce->duree_mois, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('public.annonces') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour aux annonces
                        </a>
                        @auth
                            @if (auth()->user()->membre)
                                @php
                                    $aPostule = auth()
                                        ->user()
                                        ->membre->candidatures()
                                        ->where('annonce_id', $annonce->id)
                                        ->exists();
                                @endphp
                                @if ($aPostule)
                                    <span class="btn btn-secondary float-end" disabled>
                                        <i class="fas fa-check"></i> Déjà postulé
                                    </span>
                                @else
                                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                                        data-bs-target="#modalPostuler">
                                        <i class="fas fa-hand-paper"></i> Postuler à cette tontine
                                    </button>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success float-end">
                                <i class="fas fa-sign-in-alt"></i> Connectez-vous pour postuler
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de candidature -->
    @auth
        @if (auth()->user()->membre && !$aPostule)
            <div class="modal fade" id="modalPostuler" tabindex="-1" aria-labelledby="modalPostulerLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('membre.candidature.store', $annonce) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPostulerLabel">Postuler à : {{ $annonce->titre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Message (optionnel)</label>
                                    <textarea name="message" class="form-control" rows="4"
                                        placeholder="Dites pourquoi vous souhaitez participer à cette tontine..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Envoyer ma candidature</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection
