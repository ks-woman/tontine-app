<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function form(Tontine $tontine)
    {
        return view('membre.paiement', compact('tontine'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tontine_id' => 'required|exists:tontines,id',
            'montant' => 'required|numeric|min:1000',
            'date' => 'required|date',
            'mode_paiement' => 'required|in:orange_money,wave,free_money',
            'reference_transaction' => 'required|string',
            'numero_transfert' => 'required|string',
            'nom_envoyeur' => 'required|string',
            'preuve' => 'required|image|mimes:jpg,png,pdf|max:2048',
        ]);

        $membre = Auth::user()->membre;

        // Vérifier si le membre participe à cette tontine
        $participe = $membre->tontinesParticipant()->where('tontine_id', $request->tontine_id)->exists();
        if (!$participe) {
            return back()->with('error', 'Vous ne participez pas à cette tontine.');
        }

        // Enregistrer la preuve
        $preuvePath = $request->file('preuve')->store('preuves_paiement', 'public');

        // Créer la cotisation
        Cotisation::create([
            'tontine_id' => $request->tontine_id,
            'membre_id' => $membre->id,
            'montant' => $request->montant,
            'date' => $request->date,
            'mode_paiement' => $request->mode_paiement,
            'reference_transaction' => $request->reference_transaction,
            'numero_transfert' => $request->numero_transfert,
            'nom_envoyeur' => $request->nom_envoyeur,
            'preuve_fichier' => $preuvePath,
            'statut_paiement' => 'en_attente',
        ]);

        return redirect()->route('membre.mes_cotisations')->with('success', 'Paiement envoyé. En attente de confirmation.');
    }
}
