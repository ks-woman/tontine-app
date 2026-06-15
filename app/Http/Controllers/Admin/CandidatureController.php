<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::with(['annonce', 'membre'])
            ->latest()
            ->paginate(15);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    // app/Http/Controllers/Admin/CandidatureController.php
    public function accepter(Candidature $candidature)
    {
        $candidature->update(['statut' => 'acceptee']);

        $annonce = $candidature->annonce;
        if ($annonce && $annonce->tontine_id) {
            $tontine = $annonce->tontine;
            if (!$tontine->membresParticipants()->where('membre_id', $candidature->membre_id)->exists()) {
                $tontine->membresParticipants()->attach($candidature->membre_id, ['role' => 'participant']);
            }
        }

        return back()->with('success', 'Candidature acceptée et membre ajouté à la tontine.');
    }

    public function rejeter(Candidature $candidature)
    {
        $candidature->update(['statut' => 'rejetee']);
        return back()->with('success', 'Candidature rejetée.');
    }
}
