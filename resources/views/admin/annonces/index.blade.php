@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Gestion des annonces de tontine</h2>
            <a href="{{ route('admin.annonces.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle annonce
            </a>
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
                            <th>Titre</th>
                            <th>Durée</th>
                            <th>Nb personnes</th>
                            <th>Cotisation</th>
                            <th>Statut</th>
                            <th>Publié par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($annonces as $annonce)
                            <tr>
                                <td>{{ $annonce->id }}</td>
                                <td>{{ $annonce->titre }}</td>
                                <td>{{ $annonce->duree_mois }} mois</td>
                                <td>{{ $annonce->nombre_personnes }}</td>
                                <td>{{ number_format($annonce->montant_cotisation, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @if ($annonce->statut == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($annonce->statut == 'cloturee')
                                        <span class="badge bg-secondary">Clôturée</span>
                                    @else
                                        <span class="badge bg-danger">Annulée</span>
                                    @endif
                                </td>
                                <td>{{ $annonce->createur->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.annonces.show', $annonce) }}"
                                        class="btn btn-sm btn-info">Voir</a>
                                    <a href="{{ route('admin.annonces.edit', $annonce) }}"
                                        class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('admin.annonces.destroy', $annonce) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer cette annonce ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucune annonce pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
@endsection
