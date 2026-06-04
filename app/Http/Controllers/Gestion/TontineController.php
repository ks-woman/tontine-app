<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Membre;
use Illuminate\Http\Request;
use App\Models\Tour;

class TontineController extends Controller
{
    public function index()
    {
        $tontines = Tontine::with('organisateur')->latest()->paginate(10);
        return view('tontines.index', compact('tontines'));
    }

    public function create()
    {
        $membres = Membre::all();
        return view('tontines.create', compact('membres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant_total' => 'required|numeric|min:0',
            'nbr_personne' => 'required|integer|min:2',
            'taux' => 'nullable|numeric|min:0|max:100',
            'montant_taux' => 'nullable|numeric|min:0',
            'organisateur_id' => 'required|exists:membres,id',
        ]);

        $tontine = Tontine::create($request->all());

        // Génération automatique des tours
        $this->genererTours($tontine);

        return redirect()->route('tontines.index')->with('success', 'Tontine créée avec succès.');
    }

    public function genererTours(Tontine $tontine)
    {
        // Récupérer les participants (organisateur + participants via tontine_participants)
        $participants = $tontine->membresParticipants()->pluck('membre_id')->toArray();

        // Ajouter l'organisateur s'il n'est pas déjà dans la liste
        if (!in_array($tontine->organisateur_id, $participants)) {
            $participants[] = $tontine->organisateur_id;
        }

        // Mélanger aléatoirement
        shuffle($participants);

        // Créer les tours
        foreach ($participants as $ordre => $membreId) {
            Tour::create([
                'tontine_id' => $tontine->id,
                'membre_id' => $membreId,
                'ordre' => $ordre + 1,
                'type' => 'normal',
                'statut' => 'planifie',
            ]);
        }
    }

    public function show(Tontine $tontine)
    {
        return view('tontines.show', compact('tontine'));
    }

    public function edit(Tontine $tontine)
    {
        $membres = Membre::all();
        return view('tontines.edit', compact('tontine', 'membres'));
    }

    public function update(Request $request, Tontine $tontine)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant_total' => 'required|numeric',
            'nbr_personne' => 'required|integer|min:2',
            'taux' => 'nullable|numeric',
            'montant_taux' => 'nullable|numeric',
        ]);
        $tontine->update($request->all());
        return redirect()->route('tontines.index')->with('success', 'Tontine mise à jour.');
    }

    public function destroy(Tontine $tontine)
    {
        $tontine->delete();
        return redirect()->route('tontines.index')->with('success', 'Tontine supprimée.');
    }

    public function regenererTours(Tontine $tontine)
    {
        // Supprimer les tours existants (non urgents)
        $tontine->tours()->where('type', 'normal')->delete();

        // Générer de nouveaux tours
        $this->genererTours($tontine);

        return back()->with('success', 'Ordre des tours régénéré.');
    }
}
