@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Inscription') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nom complet (name) -->
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nom complet') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="row mb-3">
                                <label for="nom"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>
                                <div class="col-md-6">
                                    <input id="nom" type="text"
                                        class="form-control @error('nom') is-invalid @enderror" name="nom"
                                        value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Prénom -->
                            <div class="row mb-3">
                                <label for="prenom"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Prénom') }}</label>
                                <div class="col-md-6">
                                    <input id="prenom" type="text"
                                        class="form-control @error('prenom') is-invalid @enderror" name="prenom"
                                        value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Téléphone -->
                            <div class="row mb-3">
                                <label for="telephone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Téléphone') }}</label>
                                <div class="col-md-6">
                                    <input id="telephone" type="text"
                                        class="form-control @error('telephone') is-invalid @enderror" name="telephone"
                                        value="{{ old('telephone') }}" required>
                                    @error('telephone')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date de naissance -->
                            <div class="row mb-3">
                                <label for="date_naissance"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date de naissance') }}</label>
                                <div class="col-md-6">
                                    <input id="date_naissance" type="date"
                                        class="form-control @error('date_naissance') is-invalid @enderror"
                                        name="date_naissance" value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lieu de naissance -->
                            <div class="row mb-3">
                                <label for="lieu_naissance"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Lieu de naissance') }}</label>
                                <div class="col-md-6">
                                    <input id="lieu_naissance" type="text"
                                        class="form-control @error('lieu_naissance') is-invalid @enderror"
                                        name="lieu_naissance" value="{{ old('lieu_naissance') }}" required>
                                    @error('lieu_naissance')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Numéro pièce identité -->
                            <div class="row mb-3">
                                <label for="numero_piece_identite"
                                    class="col-md-4 col-form-label text-md-end">{{ __('N° Pièce identité') }}</label>
                                <div class="col-md-6">
                                    <input id="numero_piece_identite" type="text"
                                        class="form-control @error('numero_piece_identite') is-invalid @enderror"
                                        name="numero_piece_identite" value="{{ old('numero_piece_identite') }}" required>
                                    @error('numero_piece_identite')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="row mb-3">
                                <label for="adresse"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Adresse') }}</label>
                                <div class="col-md-6">
                                    <textarea id="adresse" class="form-control @error('adresse') is-invalid @enderror" name="adresse">{{ old('adresse') }}</textarea>
                                    @error('adresse')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mot de passe -->
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirmer mot de passe') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <!-- Bouton -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('S\'inscrire') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
