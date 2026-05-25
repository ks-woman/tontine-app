@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Modifier la tontine</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tontines.update', $tontine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nom de la tontine</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $tontine->nom) }}" placeholder="Ex: Tontine des commerçants" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant total (FCFA)</label>
                            <input type="number" step="0.01" name="montant_total"
                                class="form-control @error('montant_total') is-invalid @enderror"
                                value="{{ old('montant_total', $tontine->montant_total) }}" required>
                            @error('montant_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nombre de personnes</label>
                            <input type="number" name="nbr_personne"
                                class="form-control @error('nbr_personne') is-invalid @enderror"
                                value="{{ old('nbr_personne', $tontine->nbr_personne) }}" required>
                            @error('nbr_personne')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Taux (%)</label>
                            <input type="number" step="0.01" name="taux"
                                class="form-control @error('taux') is-invalid @enderror"
                                value="{{ old('taux', $tontine->taux) }}">
                            @error('taux')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant du taux (FCFA)</label>
                            <input type="number" step="0.01" name="montant_taux"
                                class="form-control @error('montant_taux') is-invalid @enderror"
                                value="{{ old('montant_taux', $tontine->montant_taux) }}">
                            @error('montant_taux')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
