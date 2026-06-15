@extends('layouts.admin')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-hand-holding-usd text-primary me-2"></i> Tontines
            </h1>
            <a href="{{ route('tontines.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Nouvelle tontine
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @foreach ($tontines as $tontine)
                @php
                    // Déterminer le statut
                    $statut = 'En cours';
                    $badgeClass = 'bg-success';
                    if ($tontine->date_fin && $tontine->date_fin < now()) {
                        $statut = 'Terminée';
                        $badgeClass = 'bg-secondary';
                    } elseif ($tontine->date_debut && $tontine->date_debut > now()) {
                        $statut = 'À venir';
                        $badgeClass = 'bg-warning text-dark';
                    }
                @endphp
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100 transition-card">
                        <!-- En-tête avec nom + statut -->
                        <div
                            class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">{{ $tontine->nom ?? 'Sans nom' }}</h5>
                                <p class="text-muted small mb-0">#{{ $tontine->id }}</p>
                            </div>
                            <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ $statut }}</span>
                        </div>

                        <div class="card-body pt-3">
                            <!-- Description courte -->
                            @if ($tontine->description)
                                <div class="mb-3">
                                    <i class="fas fa-quote-left text-secondary me-1"></i>
                                    <span class="small text-muted">{{ Str::limit($tontine->description, 80) }}</span>
                                </div>
                            @else
                                <div class="mb-3 text-muted small">
                                    <i class="fas fa-ban me-1"></i> Aucune description
                                </div>
                            @endif

                            <!-- Informations clés -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2 text-center">
                                        <i class="fas fa-calendar-alt text-info"></i>
                                        <div class="small text-muted">Début</div>
                                        <span
                                            class="fw-semibold">{{ $tontine->date_debut ? $tontine->date_debut->format('d/m/Y') : '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2 text-center">
                                        <i class="fas fa-hourglass-half text-warning"></i>
                                        <div class="small text-muted">Durée</div>
                                        <span class="fw-semibold">{{ $tontine->duree_mois ?? $tontine->nbr_personne }}
                                            mois</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Détails supplémentaires -->
                            <div class="mb-2 d-flex justify-content-between">
                                <span><i class="fas fa-users text-primary me-1"></i> Participants</span>
                                <span class="fw-semibold">{{ $tontine->nbr_personne }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span><i class="fas fa-user-tie text-secondary me-1"></i> Organisateur</span>
                                <span class="fw-semibold">{{ $tontine->organisateur->prenom ?? '' }}
                                    {{ $tontine->organisateur->nom ?? '' }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span><i class="fas fa-money-bill-wave text-success me-1"></i> Montant total</span>
                                <span class="fw-bold">{{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</span>
                            </div>
                            @if ($tontine->montant_cotisation)
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-hand-holding-usd text-secondary me-1"></i> Cotisation/mois</span>
                                    <span>{{ number_format($tontine->montant_cotisation, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                        </div>

                        <!-- Pied de carte avec actions -->
                        <div class="card-footer bg-white border-0 pb-4 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-sm btn-outline-info"
                                        title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-sm btn-outline-warning"
                                        title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('tontines.participants.index', $tontine) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Participants">
                                        <i class="fas fa-users"></i>
                                    </a>
                                </div>
                                <form action="{{ route('tontines.destroy', $tontine) }}" method="POST"
                                    onsubmit="return confirm('Supprimer définitivement cette tontine ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($tontines->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $tontines->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .transition-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .transition-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1.25rem 2rem rgba(0, 0, 0, 0.12) !important;
        }

        .card-header.bg-white {
            background-color: #ffffff !important;
        }

        .bg-light.rounded-3 {
            background-color: #f8f9fc !important;
        }

        .btn-outline-info,
        .btn-outline-warning,
        .btn-outline-secondary,
        .btn-outline-danger {
            transition: all 0.2s;
        }

        .btn-outline-info:hover,
        .btn-outline-warning:hover,
        .btn-outline-secondary:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
        }
    </style>
@endpush
