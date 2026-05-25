@extends('layouts.membre')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1>Annonces de tontines</h1>
                <p class="lead">Découvrez les opportunités de tontine disponibles</p>
                <hr>
            </div>
        </div>

        @if ($annonces->count() > 0)
            <div class="row">
                @foreach ($annonces as $annonce)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $annonce->titre }}</h5>
                                <p class="card-text">{{ Str::limit($annonce->description, 120) }}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <small><i class="fas fa-clock"></i> Durée</small>
                                        <p class="mb-0"><strong>{{ $annonce->duree_mois }} mois</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <small><i class="fas fa-users"></i> Participants</small>
                                        <p class="mb-0"><strong>{{ $annonce->nombre_personnes }}</strong></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <small><i class="fas fa-money-bill-wave"></i> Cotisation</small>
                                        <p><strong>{{ number_format($annonce->montant_cotisation, 0, ',', ' ') }}
                                                FCFA/mois</strong></p>
                                    </div>
                                </div>
                                @if ($annonce->date_limite)
                                    <div class="alert alert-warning py-1 mt-2">
                                        <small><i class="fas fa-calendar-alt"></i> Date limite :
                                            {{ $annonce->date_limite->format('d/m/Y') }}</small>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('public.annonce.show', $annonce) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye"></i> Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $annonces->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Aucune annonce disponible pour le moment.
            </div>
        @endif
    </div>
@endsection
