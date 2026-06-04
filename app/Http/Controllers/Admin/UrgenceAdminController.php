<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urgence;
use App\Models\Tour;
use App\Models\Notification;
use Illuminate\Http\Request;

class UrgenceAdminController extends Controller
{
    public function index()
    {
        $urgences = Urgence::with(['tontine', 'membre'])
            ->where('statut', 'en_attente')
            ->latest()
            ->get();

        return view('admin.urgences.index', compact('urgences'));
    }

    public function valider(Urgence $urgence)
    {
        $tontine = $urgence->tontine;
        $membre = $urgence->membre;

        // 1. Marquer tous les tours planifiés comme "décalés"
        Tour::where('tontine_id', $tontine->id)
            ->where('statut', 'planifie')
            ->increment('ordre');

        // 2. Insérer le tour d’urgence (ordre 1)
        Tour::create([
            'tontine_id' => $tontine->id,
            'membre_id' => $membre->id,
            'ordre' => 1,
            'type' => 'urgence',
            'statut' => 'effectue'
        ]);

        // 3. Marquer l’urgence comme traitée
        $urgence->update(['statut' => 'traitee']);

        // 4. Notification interne pour le membre
        Notification::create([
            'user_id' => $membre->user_id,
            'titre' => '✅ Demande d’urgence acceptée',
            'message' => 'Votre demande d’urgence a été acceptée. Vous recevrez l’argent immédiatement.',
            'lien' => route('membre.mes_tontines'),
            'lue' => false,
        ]);

        return redirect()->route('admin.urgences.index')->with('success', 'Urgence validée, tours mis à jour et notification envoyée.');
    }

    public function rejeter(Urgence $urgence)
    {
        $membre = $urgence->membre;

        $urgence->update(['statut' => 'rejetee']);

        // Notification interne pour le membre
        Notification::create([
            'user_id' => $membre->user_id,
            'titre' => '❌ Demande d’urgence rejetée',
            'message' => 'Votre demande d’urgence a été rejetée. Contactez l’administrateur pour plus d’informations.',
            'lien' => route('membre.mes_tontines'),
            'lue' => false,
        ]);

        return back()->with('success', 'Demande d’urgence rejetée et notification envoyée.');
    }
}
