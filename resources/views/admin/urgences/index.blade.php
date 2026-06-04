@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Demandes d’urgence</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Membre</th>
                            <th>Tontine</th>
                            <th>Motif</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urgences as $urgence)
                            <tr>
                                <td>{{ $urgence->id }}</td>
                                <td>{{ $urgence->membre->prenom }}
                                    {{ $urgence->membre->nom }}<br><small>{{ $urgence->membre->email }}</small></br>
                                <td>{{ $urgence->tontine->nom ?? 'Sans nom' }}<br><small>{{ number_format($urgence->tontine->montant_total, 0, ',', ' ') }}
                                        FCFA</small></br>
                                <td>{{ $urgence->motif ?? 'Non renseigné' }}</br>
                                <td>{{ $urgence->created_at->format('d/m/Y H:i') }}</br>
                                <td>
                                    <span class="badge bg-warning">En attente</span>
                                    </br>
                                <td>
                                    <form action="{{ route('admin.urgences.valider', $urgence) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Valider cette demande d’urgence ?')">Valider</button>
                                    </form>
                                    <form action="{{ route('admin.urgences.rejeter', $urgence) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Rejeter cette demande ?')">Rejeter</button>
                                    </form>
                                    </br>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune demande d’urgence pour le moment.</br>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
