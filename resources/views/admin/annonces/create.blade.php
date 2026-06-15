@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Nouvelle annonce de tontine</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.annonces.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Titre de l'annonce</label>
                            <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                                value="{{ old('titre') }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description détaillée</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Durée (en mois)</label>
                            <input type="number" name="duree_mois"
                                class="form-control @error('duree_mois') is-invalid @enderror"
                                value="{{ old('duree_mois') }}" min="1" max="60" required>
                            @error('duree_mois')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Nombre de personnes</label>
                            <input type="number" name="nombre_personnes"
                                class="form-control @error('nombre_personnes') is-invalid @enderror"
                                value="{{ old('nombre_personnes') }}" min="2" max="100" required>
                            @error('nombre_personnes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Montant à cotiser (FCFA)</label>
                            <input type="number" step="1000" name="montant_cotisation"
                                class="form-control @error('montant_cotisation') is-invalid @enderror"
                                value="{{ old('montant_cotisation') }}" min="1000" required>
                            @error('montant_cotisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Date limite (optionnel)</label>
                            <input type="date" name="date_limite"
                                class="form-control @error('date_limite') is-invalid @enderror"
                                value="{{ old('date_limite') }}">
                            @error('date_limite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tontine_id" class="form-label">Tontine associée (optionnel)</label>
                            <select name="tontine_id" class="form-control @error('tontine_id') is-invalid @enderror">
                                <option value="">-- Aucune (créer la tontine plus tard) --</option>
                                @foreach (\App\Models\Tontine::all() as $tontine)
                                    <option value="{{ $tontine->id }}"
                                        {{ old('tontine_id') == $tontine->id ? 'selected' : '' }}>
                                        {{ $tontine->nom }} ({{ $tontine->organisateur->prenom }}
                                        {{ $tontine->organisateur->nom }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Publier l'annonce</button>
                    <a href="{{ route('admin.annonces.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
