@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Détails du tour #{{ $tour->id }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Ordre :</strong> {{ $tour->ordre }}</p>
                <p><strong>Tontine :</strong> {{ number_format($tour->tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                <p><strong>Membre bénéficiaire :</strong> {{ $tour->membre->prenom ?? '' }} {{ $tour->membre->nom ?? '' }}
                </p>
                <p><strong>Date de création :</strong> {{ $tour->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('tours.edit', $tour) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('tours.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
