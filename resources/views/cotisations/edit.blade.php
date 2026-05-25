@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Modifier la cotisation</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('cotisations.update', $cotisation) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Montant (FCFA)</label>
                            <input type="number" step="0.01" name="montant"
                                class="form-control @error('montant') is-invalid @enderror"
                                value="{{ old('montant', $cotisation->montant) }}" required>
                            @error('montant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Date de cotisation</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $cotisation->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tontine</label>
                            <select name="tontine_id" class="form-control" required>
                                <option value="">-- Choisir une tontine --</option>
                                @foreach ($tontines as $tontine)
                                    <option value="{{ $tontine->id }}"
                                        {{ $cotisation->tontine_id == $tontine->id ? 'selected' : '' }}>
                                        {{ $tontine->id }} - {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Membre</label>
                            <select name="membre_id" class="form-control" required>
                                <option value="">-- Choisir un membre --</option>
                                @foreach ($membres as $membre)
                                    <option value="{{ $membre->id }}"
                                        {{ $cotisation->membre_id == $membre->id ? 'selected' : '' }}>
                                        {{ $membre->prenom }} {{ $membre->nom }} - {{ $membre->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('cotisations.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
