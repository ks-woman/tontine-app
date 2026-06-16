@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Statistiques de la tontine : {{ $tontine->nom ?? 'Sans nom' }}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <strong>Montant total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-success">
                            <strong>Total cotisé :</strong> {{ number_format($totalCotise, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning">
                            <strong>Reste à cotiser :</strong>
                            {{ number_format($tontine->montant_total - $totalCotise, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                </div>

                <div class="progress mb-4" style="height: 30px;">
                    @php
                        $pourcentage =
                            $tontine->montant_total > 0 ? round(($totalCotise / $tontine->montant_total) * 100) : 0;
                    @endphp
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%;"
                        aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $pourcentage }} %
                    </div>
                </div>

                <h4>Détail par membre</h4>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Cotisation totale</th>
                            <th>Part attendue</th>
                            <th>Progression</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donnees as $d)
                            @php
                                $progression = $d['part'] > 0 ? round(($d['montant'] / $d['part']) * 100) : 0;
                            @endphp
                            <tr>
                                <td>{{ $d['membre']->prenom }} {{ $d['membre']->nom }}</td>
                                <td>{{ number_format($d['montant'], 0, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($d['part'], 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $progression }}%;">
                                            {{ $progression }} %
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
