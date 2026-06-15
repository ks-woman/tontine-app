@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Gestion des candidatures</h2>
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
                            <th>Annonce</th>
                            <th>Membre</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatures as $candidature)
                            <tr>
                                <td>{{ $candidature->id }}</td>
                                <td>{{ $candidature->annonce ? $candidature->annonce->titre : 'Annonce supprimée' }}</br>
                                <td>{{ $candidature->membre->prenom }} {{ $candidature->membre->nom }}<br>
                                    <small>{{ $candidature->membre->email }}</small>
                                </td>
                                <td>{{ $candidature->message ?? '-' }}</td>
                                <td>{{ $candidature->created_at->format('d/m/Y H:i') }}</br>
                                <td>
                                    @if ($candidature->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($candidature->statut == 'acceptee')
                                        <span class="badge bg-success">Acceptée</span>
                                    @else
                                        <span class="badge bg-danger">Rejetée</span>
                                    @endif
                                    </br>
                                <td>
                                    @if ($candidature->statut == 'en_attente')
                                        <form action="{{ route('admin.candidatures.accepter', $candidature) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-success"
                                                onclick="return confirm('Accepter cette candidature ?')">Accepter</button>
                                        </form>
                                        <form action="{{ route('admin.candidatures.rejeter', $candidature) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Rejeter cette candidature ?')">Rejeter</button>
                                        </form>
                                    @endif
                                    </br>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune candidature pour le moment.</br>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $candidatures->links() }}
            </div>
        </div>
    </div>
@endsection
