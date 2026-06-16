@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Gestion des cotisations</h2>
            <a href="{{ route('cotisations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle cotisation
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
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Tontine</th>
                            <th>Membre</th>
                            <th>Mode</th>
                            <th>Statut</th>
                            <th>Preuve</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotisations as $cotisation)
                            <tr>
                                <td>{{ $cotisation->id }}</td>
                                <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</br>
                                <td>{{ $cotisation->date->format('d/m/Y') }}</br>
                                <td>{{ number_format($cotisation->tontine->montant_total ?? 0, 0, ',', ' ') }} FCFA</br>
                                <td>{{ $cotisation->membre->prenom ?? '' }} {{ $cotisation->membre->nom ?? '' }}</br>
                                <td>
                                    @if ($cotisation->mode_paiement == 'especes')
                                        <span class="badge bg-secondary">Espèces</span>
                                    @elseif($cotisation->mode_paiement == 'orange_money')
                                        <span class="badge bg-warning">Orange Money</span>
                                    @elseif($cotisation->mode_paiement == 'wave')
                                        <span class="badge bg-info">Wave</span>
                                    @else
                                        <span class="badge bg-primary">Free Money</span>
                                    @endif
                                    </br>
                                <td>
                                    @if ($cotisation->statut_paiement == 'confirme')
                                        <span class="badge bg-success">Confirmé</span>
                                    @elseif($cotisation->statut_paiement == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté</span>
                                    @endif
                                    </br>
                                <td>
                                    @if ($cotisation->preuve_fichier)
                                        <a href="{{ asset('storage/' . $cotisation->preuve_fichier) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                    </br>
                                <td>
                                    <a href="{{ route('cotisations.show', $cotisation) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cotisations.destroy', $cotisation) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer cette cotisation ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @if ($cotisation->statut_paiement == 'en_attente')
                                        <form action="{{ route('admin.cotisations.confirmer', $cotisation) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Confirmer</button>
                                        </form>
                                        <form action="{{ route('admin.cotisations.rejeter', $cotisation) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">Rejeter</button>
                                        </form>
                                    @endif
                                    </br>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucune cotisation enregistrée.</br>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $cotisations->links() }}
            </div>
        </div>
    </div>
@endsection
