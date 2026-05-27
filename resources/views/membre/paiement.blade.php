@extends('layouts.membre')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Paiement en ligne</h4>
                        <small>Tontine : {{ $tontine->nom ?? 'Sans nom' }}</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('membre.paiement.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tontine_id" value="{{ $tontine->id }}">

                            <div class="mb-3">
                                <label>Montant (FCFA)</label>
                                <input type="number" name="montant" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Date du paiement</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label>Mode de paiement</label>
                                <select name="mode_paiement" class="form-control" required>
                                    <option value="orange_money">Orange Money</option>
                                    <option value="wave">Wave</option>
                                    <option value="free_money">Free Money</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Référence transaction</label>
                                <input type="text" name="reference_transaction" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Numéro de transfert</label>
                                <input type="text" name="numero_transfert" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Nom de l'envoyeur</label>
                                <input type="text" name="nom_envoyeur" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Preuve (capture d'écran, PDF)</label>
                                <input type="file" name="preuve" class="form-control" accept="image/*,application/pdf"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">Envoyer le paiement</button>
                            <a href="{{ route('membre.mes_tontines') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
