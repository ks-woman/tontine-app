<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    public function store(Request $request, Annonce $annonce)
    {
        $membre = Auth::user()->membre;

        // Vérifier si le membre a déjà postulé
        $existe = Candidature::where('annonce_id', $annonce->id)
            ->where('membre_id', $membre->id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Vous avez déjà postulé à cette annonce.');
        }

        Candidature::create([
            'annonce_id' => $annonce->id,
            'membre_id' => $membre->id,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Votre candidature a été envoyée avec succès.');
    }

    public function mesCandidatures()
    {
        $membre = Auth::user()->membre;
        $candidatures = $membre->candidatures()->with('annonce')->latest()->paginate(10);
        return view('membre.mes_candidatures', compact('candidatures'));
    }
}
