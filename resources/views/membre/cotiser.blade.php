@extends('layouts.membre')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Effectuer une cotisation</h4>
                        <small>Tontine : {{ $tontine->nom ?? 'Sans nom' }} -
                            {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('membre.cotiser.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tontine_id" value="{{ $tontine->id }}">

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label">Montant (FCFA)</label>
                                <div class="col-md-8">
                                    <input type="number" name="montant"
                                        class="form-control @error('montant') is-invalid @enderror" required>
                                    @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label">Date</label>
                                <div class="col-md-8">
                                    <input type="date" name="date"
                                        class="form-control @error('date') is-invalid @enderror" value="{{ date('Y-m-d') }}"
                                        required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label">Mode de paiement</label>
                                <div class="col-md-8">
                                    <select name="mode_paiement" id="mode_paiement"
                                        class="form-control @error('mode_paiement') is-invalid @enderror" required>
                                        <option value="especes">Espèces</option>
                                        <option value="orange_money">Orange Money</option>
                                        <option value="wave">Wave</option>
                                        <option value="free_money">Free Money</option>
                                    </select>
                                    @error('mode_paiement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div id="champs_transfert" style="display: none;">
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Référence transaction</label>
                                    <div class="col-md-8">
                                        <input type="text" name="reference_transaction" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Numéro de transfert</label>
                                    <div class="col-md-8">
                                        <input type="text" name="numero_transfert" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Nom de l'envoyeur</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nom_envoyeur" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Preuve (capture d'écran)</label>
                                    <div class="col-md-8">
                                        <input type="file" name="preuve" class="form-control"
                                            accept="image/*,application/pdf">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Envoyer la cotisation</button>
                                    <a href="{{ route('membre.mes_tontines') }}" class="btn btn-secondary">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('mode_paiement').addEventListener('change', function() {
                const champs = document.getElementById('champs_transfert');
                if (this.value !== 'especes') {
                    champs.style.display = 'block';
                } else {
                    champs.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection
