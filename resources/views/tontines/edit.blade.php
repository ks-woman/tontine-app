@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Modifier la tontine</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tontines.update', $tontine) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $tontine->nom) }}"
                                required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $tontine->description) }}</textarea>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Durée (mois)</label>
                            <input type="number" name="duree_mois" class="form-control"
                                value="{{ old('duree_mois', $tontine->duree_mois) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Date de début</label>
                            <input type="date" name="date_debut" class="form-control"
                                value="{{ old('date_debut', $tontine->date_debut?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Date de fin</label>
                            <input type="date" name="date_fin" class="form-control"
                                value="{{ old('date_fin', $tontine->date_fin?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Fréquence</label>
                            <select name="frequence" class="form-control">
                                <option value="mensuelle" {{ $tontine->frequence == 'mensuelle' ? 'selected' : '' }}>
                                    Mensuelle</option>
                                <option value="trimestrielle"
                                    {{ $tontine->frequence == 'trimestrielle' ? 'selected' : '' }}>Trimestrielle</option>
                                <option value="semestrielle" {{ $tontine->frequence == 'semestrielle' ? 'selected' : '' }}>
                                    Semestrielle</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant total</label>
                            <input type="number" step="0.01" name="montant_total" class="form-control"
                                value="{{ old('montant_total', $tontine->montant_total) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant cotisation</label>
                            <input type="number" step="0.01" name="montant_cotisation" class="form-control"
                                value="{{ old('montant_cotisation', $tontine->montant_cotisation) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nombre de personnes</label>
                            <input type="number" name="nbr_personne" class="form-control"
                                value="{{ old('nbr_personne', $tontine->nbr_personne) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Taux (%)</label>
                            <input type="number" step="0.01" name="taux" class="form-control"
                                value="{{ old('taux', $tontine->taux) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant du taux</label>
                            <input type="number" step="0.01" name="montant_taux" class="form-control"
                                value="{{ old('montant_taux', $tontine->montant_taux) }}">
                        </div>

                        <div class="mb-3">
                            <label for="tontine_id" class="form-label">Tontine associée (optionnel)</label>
                            <select name="tontine_id" class="form-control @error('tontine_id') is-invalid @enderror">
                                <option value="">-- Aucune --</option>
                                @foreach (\App\Models\Tontine::all() as $tontine)
                                    <option value="{{ $tontine->id }}"
                                        {{ old('tontine_id', $annonce->tontine_id) == $tontine->id ? 'selected' : '' }}>
                                        {{ $tontine->nom }} ({{ $tontine->organisateur->prenom }}
                                        {{ $tontine->organisateur->nom }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
