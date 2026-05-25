<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotisationController extends Controller
{
    public function create(Tontine $tontine)
    {
        return view('membre.cotiser', compact('tontine'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tontine_id' => 'required|exists:tontines,id',
            'montant' => 'required|numeric|min:1000',
            'date' => 'required|date',
            'mode_paiement' => 'required|in:especes,orange_money,wave,free_money',
            'reference_transaction' => 'required_if:mode_paiement,!=,especes|nullable|string',
            'numero_transfert' => 'required_if:mode_paiement,!=,especes|nullable|string',
            'nom_envoyeur' => 'nullable|string',
            'preuve' => 'nullable|image|mimes:jpg,png,pdf|max:2048',
        ]);

        $data = $request->except('preuve');
        $data['membre_id'] = Auth::user()->membre->id;
        $data['statut_paiement'] = $request->mode_paiement == 'especes' ? 'confirme' : 'en_attente';

        if ($request->hasFile('preuve')) {
            $data['preuve_fichier'] = $request->file('preuve')->store('preuves_cotisations', 'public');
        }

        Cotisation::create($data);

        $message = $request->mode_paiement == 'especes'
            ? 'Cotisation enregistrée avec succès.'
            : 'Cotisation enregistrée. En attente de confirmation par l\'administrateur.';

        return redirect()->route('membre.mes_cotisations')->with('success', $message);
    }
}
