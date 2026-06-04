<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Urgence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrgenceController extends Controller
{
    public function demander(Request $request, Tontine $tontine)
    {
        $request->validate([
            'motif' => 'required|string|min:10',
        ]);

        $membre = Auth::user()->membre;

        // Vérifier si le membre participe à cette tontine
        $participe = $tontine->membresParticipants()->where('membre_id', $membre->id)->exists();
        if (!$participe) {
            return back()->with('error', 'Vous ne participez pas à cette tontine.');
        }

        // Vérifier si une demande est déjà en attente
        $existe = Urgence::where('tontine_id', $tontine->id)
            ->where('membre_id', $membre->id)
            ->where('statut', 'en_attente')
            ->exists();
        if ($existe) {
            return back()->with('error', 'Vous avez déjà une demande d’urgence en attente.');
        }

        Urgence::create([
            'tontine_id' => $tontine->id,
            'membre_id' => $membre->id,
            'statut' => 'en_attente',
            'motif' => $request->motif,
        ]);

        return back()->with('success', 'Demande d’urgence envoyée. L’administrateur va valider.');
    }
}
