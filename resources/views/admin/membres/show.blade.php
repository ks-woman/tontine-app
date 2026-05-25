@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Détails du membre</h2>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nom :</strong> {{ $membre->nom }}</p>
                        <p><strong>Prénom :</strong> {{ $membre->prenom }}</p>
                        <p><strong>Email :</strong> {{ $membre->email }}</p>
                        <p><strong>Téléphone :</strong> {{ $membre->telephone }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date de naissance :</strong> {{ $membre->date_naissance->format('d/m/Y') }}</p>
                        <p><strong>Lieu de naissance :</strong> {{ $membre->lieu_naissance }}</p>
                        <p><strong>N° Pièce :</strong> {{ $membre->numero_piece_identite }}</p>
                        <p><strong>Adresse :</strong> {{ $membre->adresse ?? 'Non renseignée' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date d'adhésion :</strong> {{ $membre->date_adhesion->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
