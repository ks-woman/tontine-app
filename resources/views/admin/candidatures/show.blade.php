@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Détails de la candidature</h3>
            </div>
            <div class="card-body">
                <p><strong>ID :</strong> {{ $candidature->id }}</p>
                <p><strong>Annonce :</strong> {{ $candidature->annonce->titre ?? 'Annonce supprimée' }}</p>
                <p><strong>Membre :</strong> {{ $candidature->membre->prenom }} {{ $candidature->membre->nom }}</p>
                <p><strong>Email :</strong> {{ $candidature->membre->email }}</p>
                <p><strong>Message :</strong> {{ $candidature->message ?? 'Aucun message' }}</p>
                <p><strong>Statut :</strong>
                    @if ($candidature->statut == 'en_attente')
                        <span class="badge bg-warning">En attente</span>
                    @elseif($candidature->statut == 'acceptee')
                        <span class="badge bg-success">Acceptée</span>
                    @else
                        <span class="badge bg-danger">Rejetée</span>
                    @endif
                </p>
                <p><strong>Date de candidature :</strong> {{ $candidature->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.candidatures.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
