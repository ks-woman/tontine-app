@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestion des tours</h2>
            <a href="{{ route('tours.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau tour
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
                            <th>Ordre</th>
                            <th>Tontine</th>
                            <th>Membre bénéficiaire</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr>
                                <td><span class="badge bg-primary rounded-pill">Ordre {{ $tour->ordre }}</span></td>
                                <td>
                                    <strong>{{ $tour->tontine?->nom ?? 'Tontine introuvable' }}</strong><br>
                                    <small>
                                        @if ($tour->tontine?->montant_total)
                                            {{ number_format($tour->tontine->montant_total, 0, ',', ' ') }} FCFA
                                        @else
                                            —
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    {{ $tour->membre->prenom ?? '' }} {{ $tour->membre->nom ?? '' }}<br>
                                    <small>{{ $tour->membre->email ?? '' }}</small>
                                </td>
                                <td>
                                    @if ($tour->statut == 'planifie')
                                        <span class="badge bg-info">Planifié</span>
                                    @elseif($tour->statut == 'effectue')
                                        <span class="badge bg-success">Effectué</span>
                                    @elseif($tour->statut == 'decalé')
                                        <span class="badge bg-warning">Décalé</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $tour->statut }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tours.edit', $tour) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tours.destroy', $tour) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Supprimer ce tour ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun tour enregistré. <a
                                        href="{{ route('tours.create') }}">Ajouter un tour</a></br>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
@endsection
