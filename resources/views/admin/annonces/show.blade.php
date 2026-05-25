@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $annonce->titre }}</h3>
                <div>
                    <a href="{{ route('admin.annonces.edit', $annonce) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.annonces.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
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
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-calendar-alt fa-2x text-primary mb-2 d-block"></i>
                            <strong>Durée</strong><br>
                            {{ $annonce->duree_mois }} mois
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-users fa-2x text-success mb-2 d-block"></i>
                            <strong>Participants</strong><br>
                            {{ $annonce->nombre_personnes }} personnes
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-money-bill-wave fa-2x text-warning mb-2 d-block"></i>
                            <strong>Cotisation</strong><br>
                            {{ number_format($annonce->montant_cotisation, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-tag fa-2x text-info mb-2 d-block"></i>
                            <strong>Statut</strong><br>
                            @if ($annonce->statut == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($annonce->statut == 'cloturee')
                                <span class="badge bg-secondary">Clôturée</span>
                            @else
                                <span class="badge bg-danger">Annulée</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-calendar-week fa-2x text-secondary mb-2 d-block"></i>
                            <strong>Date limite</strong><br>
                            {{ $annonce->date_limite ? $annonce->date_limite->format('d/m/Y') : 'Non définie' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light p-3 rounded">
                            <i class="fas fa-user-circle fa-2x text-secondary mb-2 d-block"></i>
                            <strong>Publié par</strong><br>
                            {{ $annonce->createur->name ?? 'N/A' }} le {{ $annonce->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">Dernière modification : {{ $annonce->updated_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
@endsection
