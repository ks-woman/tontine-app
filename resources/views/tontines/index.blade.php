@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Tontines</h2>
            <a href="{{ route('tontines.create') }}" class="btn btn-primary">+ Nouvelle tontine</a>
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
                            <th>Nom</th>
                            <th>Montant total</th>
                            <th>Nombre personnes</th>
                            <th>Organisateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tontines as $tontine)
                            <tr>
                                <td>{{ $tontine->id }}</td>
                                <td>{{ $tontine->nom ?? 'Sans nom' }}</td>
                                <td>{{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</br>
                                <td>{{ $tontine->nbr_personne }}</br>
                                <td>{{ $tontine->organisateur->prenom ?? '' }} {{ $tontine->organisateur->nom ?? '' }}</br>
                                <td>
                                    <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-sm btn-info">Voir</a>
                                    <a href="{{ route('tontines.edit', $tontine) }}"
                                        class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="{{ route('tontines.participants.index', $tontine) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fas fa-users"></i> Participants
                                    </a>
                                    <form action="{{ route('tontines.destroy', $tontine) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $tontines->links() }}
            </div>
        </div>
    </div>
@endsection
