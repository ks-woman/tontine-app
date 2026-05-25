@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestion des membres</h2>
            <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau membre
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'adhésion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($membres as $membre)
                            <tr>
                                <td>{{ $membre->id }}</td>
                                <td>{{ $membre->prenom }} {{ $membre->nom }}</td>
                                <td>{{ $membre->email }}</td>
                                <td>{{ $membre->telephone }}</td>
                                <td>{{ $membre->date_adhesion->format('d/m/Y') }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.membres.destroy', $membre) }}" method="POST"
                                        onsubmit="return confirm('Supprimer ce membre ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $membres->links() }}
            </div>
        </div>
    </div>
@endsection
