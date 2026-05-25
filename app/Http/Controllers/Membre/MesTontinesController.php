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

        $tontinesOrganisees = $membre->tontinesOrganisees()->with('tours')->get();
        $tontinesCoOrganisees = $membre->tontinesCoOrganisees()->with('organisateur')->get();

        $tontinesParticipants = $membre->tours()
            ->with('tontine.organisateur')
            ->get()
            ->map(function ($tour) {
                return $tour->tontine;
            })
            ->filter()
            ->unique('id');

        return view('membre.mes_tontines', compact('tontinesOrganisees', 'tontinesCoOrganisees', 'tontinesParticipants'));
    }
}
