@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Modifier le membre</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.membres.update', $membre) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $membre->nom) }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control"
                                value="{{ old('prenom', $membre->prenom) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Téléphone</label>
                            <input type="text" name="telephone" class="form-control"
                                value="{{ old('telephone', $membre->telephone) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control"
                                value="{{ old('adresse', $membre->adresse) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance" class="form-control"
                                value="{{ old('date_naissance', $membre->date_naissance) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lieu de naissance</label>
                            <input type="text" name="lieu_naissance" class="form-control"
                                value="{{ old('lieu_naissance', $membre->lieu_naissance) }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection
