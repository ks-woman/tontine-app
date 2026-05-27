<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MesTontinesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $membre = $user->membre;

        // Tontines où il est organisateur
        $tontinesOrganisees = $membre->tontinesOrganisees()->with('tours')->get();

        // Tontines où il est co-organisateur (via la table pivot)
        $tontinesCoOrganisees = $membre->tontinesCoOrganisees()->with('organisateur')->get();

        // Tontines où il participe (via tontine_participants)
        $tontinesParticipants = $membre->tontinesParticipant()
            ->with('organisateur')
            ->get();

        return view('membre.mes_tontines', compact('tontinesOrganisees', 'tontinesCoOrganisees', 'tontinesParticipants'));
    }
}
