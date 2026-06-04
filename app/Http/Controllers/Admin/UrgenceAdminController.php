<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urgence;
use App\Models\Tour;
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

        return redirect()->route('admin.urgences.index')->with('success', 'Urgence validée, tours mis à jour.');
    }

    public function rejeter(Urgence $urgence)
    {
        $urgence->update(['statut' => 'rejetee']);
        return back()->with('success', 'Demande d’urgence rejetée.');
    }
}
