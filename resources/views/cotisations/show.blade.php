@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Détails de la cotisation</h3>
            </div>
            <div class="card-body">
                <p><strong>ID :</strong> {{ $cotisation->id }}</p>
                <p><strong>Montant :</strong> {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</p>
                <p><strong>Date :</strong> {{ $cotisation->date->format('d/m/Y') }}</p>
                <p><strong>Tontine :</strong> {{ number_format($cotisation->tontine->montant_total ?? 0, 0, ',', ' ') }}
                    FCFA</p>
                <p><strong>Membre :</strong> {{ $cotisation->membre->prenom ?? '' }} {{ $cotisation->membre->nom ?? '' }}
                </p>
                <p><strong>Date d'enregistrement :</strong> {{ $cotisation->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('cotisations.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
