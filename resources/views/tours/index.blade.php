@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
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
                            <th>ID</th>
                            <th>Ordre</th>
                            <th>Tontine</th>
                            <th>Membre bénéficiaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr>
                                <td>{{ $tour->id }}</td>
                                <td>{{ $tour->ordre }}</td>
                                <td>{{ $tour->tontine->montant_total ?? 'N/A' }} FCFA</td>
                                <td>{{ $tour->membre->prenom ?? '' }} {{ $tour->membre->nom ?? '' }}</td>
                                <td>
                                    <a href="{{ route('tours.show', $tour) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun tour enregistré.</td>
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
