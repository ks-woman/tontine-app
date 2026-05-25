@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Ajouter un membre</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.membres.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                                value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                                value="{{ old('prenom') }}" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Téléphone</label>
                            <input type="text" name="telephone"
                                class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}"
                                required>
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance"
                                class="form-control @error('date_naissance') is-invalid @enderror"
                                value="{{ old('date_naissance') }}" required>
                            @error('date_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lieu de naissance</label>
                            <input type="text" name="lieu_naissance"
                                class="form-control @error('lieu_naissance') is-invalid @enderror"
                                value="{{ old('lieu_naissance') }}" required>
                            @error('lieu_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>N° Pièce d'identité</label>
                            <input type="text" name="numero_piece_identite"
                                class="form-control @error('numero_piece_identite') is-invalid @enderror"
                                value="{{ old('numero_piece_identite') }}" required>
                            @error('numero_piece_identite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                value="{{ old('adresse') }}">
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Créer le membre</button>
                        <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
