@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h2>Participants de la tontine : {{ $tontine->nom ?? 'Sans nom' }}</h2>
            <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Retour</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ajouter un participant</div>
                    <div class="card-body">
                        <form action="{{ route('admin.tontines.participants.store', $tontine) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Membre</label>
                                <select name="membre_id" class="form-control" required>
                                    <option value="">-- Choisir --</option>
                                    @foreach ($membresDisponibles as $membre)
                                        <option value="{{ $membre->id }}">{{ $membre->prenom }} {{ $membre->nom }}
                                            ({{ $membre->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Rôle</label>
                                <select name="role" class="form-control" required>
                                    <option value="participant">Participant</option>
                                    <option value="coorganisateur">Co-organisateur</option>
                                    <option value="organisateur">Organisateur</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Liste des participants</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participants as $participant)
                                    <tr>
                                        <td>{{ $participant->prenom }}
                                            {{ $participant->nom }}<br><small>{{ $participant->email }}</small></br>
                                        <td>
                                            @if ($participant->pivot->role == 'organisateur')
                                                <span class="badge bg-primary">Organisateur</span>
                                            @elseif($participant->pivot->role == 'coorganisateur')
                                                <span class="badge bg-warning">Co-organisateur</span>
                                            @else
                                                <span class="badge bg-secondary">Participant</span>
                                            @endif
                                            </br>
                                        <td>
                                            <form
                                                action="{{ route('admin.tontines.participants.destroy', [$tontine, $participant]) }}"
                                                method="POST" style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Retirer ce participant ?')">Retirer</button>
                                            </form>
                                            </br>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Aucun participant.</br>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
