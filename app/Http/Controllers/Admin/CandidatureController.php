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

    public function accepter(Candidature $candidature)
    {
        $candidature->update(['statut' => 'acceptee']);
        return back()->with('success', 'Candidature acceptée avec succès.');
    }

    public function rejeter(Candidature $candidature)
    {
        $candidature->update(['statut' => 'rejetee']);
        return back()->with('success', 'Candidature rejetée.');
    }
}
