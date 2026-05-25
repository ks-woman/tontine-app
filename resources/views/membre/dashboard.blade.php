@extends('layouts.membre')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Mon espace membre</h1>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Bienvenue</h5>
                        <p class="card-text">{{ $membre->prenom ?? '' }} {{ $membre->nom ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Email</h5>
                        <p class="card-text">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Téléphone</h5>
                        <p class="card-text">{{ $membre->telephone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <strong>📢 Les annonces de tontine sont disponibles</strong>
            <a href="{{ route('public.annonces') }}" class="alert-link">Cliquez ici pour voir les annonces</a>
        </div>
    </div>
@endsection
