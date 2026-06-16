<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Membre;
use App\Models\Tour;
use Illuminate\Http\Request;

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
            'description' => 'nullable|string',
            'duree_mois' => 'nullable|integer|min:1',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'frequence' => 'in:mensuelle,trimestrielle,semestrielle',
            'montant_total' => 'required|numeric|min:0',
            'montant_cotisation' => 'nullable|numeric|min:0',
            'nbr_personne' => 'required|integer|min:2',
            'taux' => 'nullable|numeric|min:0|max:100',
            'montant_taux' => 'nullable|numeric|min:0',
            'organisateur_id' => 'required|exists:membres,id',
        ]);

        $tontine = Tontine::create($request->all());

        // Optionnel : ajouter l'organisateur comme participant (si pas déjà)
        $tontine->membresParticipants()->syncWithoutDetaching([$request->organisateur_id => ['role' => 'organisateur']]);

        return redirect()->route('tontines.index')->with('success', 'Tontine créée avec succès. Veuillez ajouter des participants puis lancer le tirage au sort.');
    }

    public function show(Tontine $tontine)
    {
        return view('tontines.show', compact('tontine'));
    }

    public function edit(Tontine $tontine)
    {
        $this->authorize('update', $tontine);
        $membres = Membre::all();
        return view('tontines.edit', compact('tontine', 'membres'));
    }

    public function update(Request $request, Tontine $tontine)
    {
        $this->authorize('update', $tontine);
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant_total' => 'required|numeric',
            'nbr_personne' => 'required|integer|min:2',
            'taux' => 'nullable|numeric',
            'montant_taux' => 'nullable|numeric',
            'description' => 'nullable|string',
            'duree_mois' => 'nullable|integer|min:1',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'montant_cotisation' => 'nullable|numeric|min:0',
            'frequence' => 'in:mensuelle,trimestrielle,semestrielle',
        ]);
        $tontine->update($request->all());
        return redirect()->route('tontines.index')->with('success', 'Tontine mise à jour.');
    }

    public function destroy(Tontine $tontine)
    {
        $tontine->delete();
        return redirect()->route('tontines.index')->with('success', 'Tontine supprimée.');
    }

    // Tirage au sort : génère les tours aléatoirement
    public function tirerAuSort(Tontine $tontine)
    {
        $this->authorize('update', $tontine);

        $participants = $tontine->membresParticipants()->pluck('membres.id')->toArray();
        if (count($participants) < 2) {
            return back()->with('error', 'Il faut au moins deux participants pour faire un tirage au sort.');
        }

        shuffle($participants);

        // Supprimer les tours existants (non urgents)
        $tontine->tours()->where('type', 'normal')->delete();

        foreach ($participants as $index => $membreId) {
            Tour::create([
                'tontine_id' => $tontine->id,
                'membre_id' => $membreId,
                'ordre' => $index + 1,
                'type' => 'normal',
                'statut' => 'planifie',
            ]);
        }

        return back()->with('success', 'L’ordre des tours a été tiré au sort.');
    }

    public function statistiques(Tontine $tontine)
    {
        // Vérifier que l'utilisateur est admin ou organisateur
        $this->authorize('update', $tontine);

        // Récupérer tous les participants avec leurs cotisations
        $participants = $tontine->membresParticipants()->with(['cotisations' => function ($query) use ($tontine) {
            $query->where('tontine_id', $tontine->id);
        }])->get();

        // Calcul des totaux
        $totalCotise = 0;
        $donnees = $participants->map(function ($membre) use ($tontine, &$totalCotise) {
            $montant = $membre->cotisations->sum('montant');
            $totalCotise += $montant;
            return [
                'membre' => $membre,
                'montant' => $montant,
                'part' => $tontine->montant_total / $tontine->nbr_personne,
            ];
        });

        return view('tontines.statistiques', compact('tontine', 'donnees', 'totalCotise'));
    }

    public function validerProchainTour(Tontine $tontine)
    {
        $this->authorize('update', $tontine); // ou une autre politique

        // Récupérer le mois et l'année actuels (ou on peut permettre de choisir un mois)
        $mois = now()->month;
        $annee = now()->year;

        // Récupérer tous les participants
        $participants = $tontine->membresParticipants()->pluck('membre_id')->toArray();
        if (!in_array($tontine->organisateur_id, $participants)) {
            $participants[] = $tontine->organisateur_id;
        }
        $nombreParticipants = count($participants);

        // Compter les cotisations confirmées pour ce mois
        $cotisationsConfirmes = Cotisation::where('tontine_id', $tontine->id)
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->where('statut_paiement', 'confirme')
            ->count();

        if ($cotisationsConfirmes < $nombreParticipants) {
            return back()->with('error', 'Toutes les cotisations du mois ne sont pas encore confirmées. Il manque ' . ($nombreParticipants - $cotisationsConfirmes) . ' cotisation(s).');
        }

        // Récupérer le prochain tour planifié
        $tour = Tour::where('tontine_id', $tontine->id)
            ->where('statut', 'planifie')
            ->orderBy('ordre')
            ->first();

        if (!$tour) {
            return back()->with('error', 'Aucun tour planifié pour cette tontine.');
        }

        // Marquer le tour comme effectué
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

        return back()->with('success', 'Le tour a été validé et le bénéficiaire a été notifié.');
    }
}
