@extends('layouts.membre')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Mes notifications</h1>
            @if ($nonLuesCount > 0)
                <form method="POST" action="{{ route('membre.notifications.marquer-tout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Tout marquer comme lu</button>
                </form>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notif)
                    <div class="list-group-item {{ $notif->lue ? '' : 'bg-light border-start border-primary border-3' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $notif->titre }}</strong>
                                <p class="mb-1">{{ $notif->message }}</p>
                                <small class="text-muted">Reçue le {{ $notif->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            @if (!$notif->lue)
                                <form method="POST" action="{{ route('membre.notifications.marquer', $notif->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Marquer comme
                                        lue</button>
                                </form>
                            @else
                                <span class="badge bg-secondary">Lue</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="list-group-item text-center">Aucune notification.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
