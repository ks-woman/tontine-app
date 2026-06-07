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

        // Tontines où il est organisateur (avec tours)
        $tontinesOrganisees = $membre->tontinesOrganisees()->with('tours')->get();

        // Tontines où il est co-organisateur (avec tours et organisateur)
        $tontinesCoOrganisees = $membre->tontinesCoOrganisees()->with('tours', 'organisateur')->get();

        // Tontines où il participe (avec tours et organisateur)
        $tontinesParticipants = $membre->tontinesParticipant()
            ->with('tours', 'organisateur')
            ->get();

        return view('membre.mes_tontines', compact('tontinesOrganisees', 'tontinesCoOrganisees', 'tontinesParticipants'));
    }
}
