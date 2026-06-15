@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Créer une tontine</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tontines.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nom de la tontine</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Objectif, règles, conditions..."></textarea>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Durée (mois)</label>
                            <input type="number" name="duree_mois" class="form-control" min="1" placeholder="Ex: 6">
                            <small class="text-muted">Laissez vide pour utiliser le nombre de participants</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Date de début</label>
                            <input type="date" name="date_debut" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Date de fin (optionnelle)</label>
                            <input type="date" name="date_fin" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Fréquence</label>
                            <select name="frequence" class="form-control">
                                <option value="mensuelle">Mensuelle</option>
                                <option value="trimestrielle">Trimestrielle</option>
                                <option value="semestrielle">Semestrielle</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant total (FCFA)</label>
                            <input type="number" step="0.01" name="montant_total" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant cotisation (FCFA/mois)</label>
                            <input type="number" step="0.01" name="montant_cotisation" class="form-control">
                            <small class="text-muted">Si renseigné, prime sur le montant total</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nombre de personnes</label>
                            <input type="number" name="nbr_personne" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Taux (%)</label>
                            <input type="number" step="0.01" name="taux" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Montant du taux (FCFA)</label>
                            <input type="number" step="0.01" name="montant_taux" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Organisateur</label>
                            <select name="organisateur_id" class="form-control" required>
                                <option value="">-- Choisir --</option>
                                @foreach ($membres as $membre)
                                    <option value="{{ $membre->id }}">{{ $membre->prenom }} {{ $membre->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer</button>
                    <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
