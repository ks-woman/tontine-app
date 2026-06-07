@extends('layouts.membre')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Mes tontines</h1>
                <hr>
            </div>
        </div>

        <!-- Tontines que j'organise -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="text-primary"><i class="fas fa-crown"></i> Tontines que j'organise</h3>
                @if ($tontinesOrganisees->count() > 0)
                    <div class="row">
                        @foreach ($tontinesOrganisees as $tontine)
                            @include('membre.partials.tontine_card', [
                                'tontine' => $tontine,
                                'role' => 'organisateur',
                            ])
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous n'organisez aucune tontine.</div>
                @endif
            </div>
        </div>

        <!-- Tontines où je suis co-organisateur -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="text-success"><i class="fas fa-handshake"></i> Tontines où je suis co-organisateur</h3>
                @if ($tontinesCoOrganisees->count() > 0)
                    <div class="row">
                        @foreach ($tontinesCoOrganisees as $tontine)
                            @include('membre.partials.tontine_card', [
                                'tontine' => $tontine,
                                'role' => 'coorganisateur',
                            ])
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous n'êtes co-organisateur d'aucune tontine.</div>
                @endif
            </div>
        </div>

        <!-- Tontines où je participe -->
        <div class="row">
            <div class="col-12">
                <h3 class="text-warning"><i class="fas fa-users"></i> Tontines où je participe</h3>
                @if ($tontinesParticipants->count() > 0)
                    <div class="row">
                        @foreach ($tontinesParticipants as $tontine)
                            @include('membre.partials.tontine_card', [
                                'tontine' => $tontine,
                                'role' => 'participant',
                            ])
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Vous ne participez à aucune tontine.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
