@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Ajouter un tour</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('tours.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Ordre</label>
                            <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror"
                                value="{{ old('ordre') }}" required>
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tontine</label>
                            <select name="tontine_id" class="form-control @error('tontine_id') is-invalid @enderror"
                                required>
                                <option value="">-- Choisir une tontine --</option>
                                @foreach ($tontines as $tontine)
                                    <option value="{{ $tontine->id }}"
                                        {{ old('tontine_id') == $tontine->id ? 'selected' : '' }}>
                                        {{ $tontine->id }} - {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA
                                    </option>
                                @endforeach
                            </select>
                            @error('tontine_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Membre bénéficiaire</label>
                            <select name="membre_id" class="form-control @error('membre_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un membre --</option>
                                @foreach ($membres as $membre)
                                    <option value="{{ $membre->id }}"
                                        {{ old('membre_id') == $membre->id ? 'selected' : '' }}>
                                        {{ $membre->prenom }} {{ $membre->nom }} - {{ $membre->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('membre_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('tours.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
