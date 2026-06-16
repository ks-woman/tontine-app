<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\Tontine;
use App\Models\Membre;
use App\Models\Tour;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    public function index()
    {
        $cotisations = Cotisation::with(['tontine', 'membre'])->latest()->paginate(10);
        return view('cotisations.index', compact('cotisations'));
    }

    public function create()
    {
        $tontines = Tontine::all();
        $membres = Membre::all();
        return view('cotisations.create', compact('tontines', 'membres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'tontine_id' => 'required|exists:tontines,id',
            'membre_id' => 'required|exists:membres,id',
        ]);

        // Vérifier unicité (membre, tontine, date)
        $exists = Cotisation::where('membre_id', $request->membre_id)
            ->where('tontine_id', $request->tontine_id)
            ->where('date', $request->date)
            ->exists();
        if ($exists) {
            return back()->withErrors(['date' => 'Un membre ne peut pas avoir deux cotisations pour la même tontine à la même date.'])->withInput();
        }

        Cotisation::create($request->all());
        return redirect()->route('cotisations.index')->with('success', 'Cotisation ajoutée avec succès.');
    }

    public function show(Cotisation $cotisation)
    {
        return view('cotisations.show', compact('cotisation'));
    }

    public function edit(Cotisation $cotisation)
    {
        $tontines = Tontine::all();
        $membres = Membre::all();
        return view('cotisations.edit', compact('cotisation', 'tontines', 'membres'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'tontine_id' => 'required|exists:tontines,id',
            'membre_id' => 'required|exists:membres,id',
        ]);

        $exists = Cotisation::where('membre_id', $request->membre_id)
            ->where('tontine_id', $request->tontine_id)
            ->where('date', $request->date)
            ->where('id', '!=', $cotisation->id)
            ->exists();
        if ($exists) {
            return back()->withErrors(['date' => 'Conflit de date pour ce membre et cette tontine.'])->withInput();
        }

        $cotisation->update($request->all());
        return redirect()->route('cotisations.index')->with('success', 'Cotisation mise à jour.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();
        return redirect()->route('cotisations.index')->with('success', 'Cotisation supprimée.');
    }

    public function confirmer(Cotisation $cotisation)
    {
        $cotisation->update(['statut_paiement' => 'confirme']);

        // Vérifier si le tour doit être validé
        $this->verifierEtValiderTour($cotisation);

        return back()->with('success', 'Paiement confirmé.');
    }

    public function rejeter(Cotisation $cotisation)
    {
        $cotisation->update(['statut_paiement' => 'rejete']);
        return back()->with('success', 'Paiement rejeté.');
    }

    private function verifierEtValiderTour(Cotisation $cotisation)
    {
        $tontine = $cotisation->tontine;
        if (!$tontine) {
            return;
        }

        $mois = $cotisation->date->month;
        $annee = $cotisation->date->year;

        // Récupérer tous les participants (incluant organisateur)
        $participants = $tontine->membresParticipants()->pluck('membre_id')->toArray();
        if (!in_array($tontine->organisateur_id, $participants)) {
            $participants[] = $tontine->organisateur_id;
        }
        $nombreParticipants = count($participants);

        // Compter les cotisations confirmées pour ce mois et cette tontine
        $cotisationsConfirmes = Cotisation::where('tontine_id', $tontine->id)
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->where('statut_paiement', 'confirme')
            ->count();

        if ($cotisationsConfirmes >= $nombreParticipants) {
            // Récupérer le premier tour planifié (prochain bénéficiaire)
            $tour = Tour::where('tontine_id', $tontine->id)
                ->where('statut', 'planifie')
                ->orderBy('ordre')
                ->first();

            if ($tour) {
                $tour->statut = 'effectue';
                $tour->save();

                // Notification au bénéficiaire
                $beneficiaire = $tour->membre->user;
                if ($beneficiaire) {
                    $beneficiaire->notifications()->create([
                        'titre' => 'Tour effectué',
                        'message' => "Félicitations ! Vous avez reçu l'argent du tour numéro {$tour->ordre} pour la tontine '{$tontine->nom}'.",
                        'lien' => route('membre.mes_tontines'),
                    ]);
                }
            }
        }
    }
}
