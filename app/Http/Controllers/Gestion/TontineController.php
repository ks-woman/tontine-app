<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Membre;
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
            'montant_total' => 'required|numeric',
            'nbr_personne' => 'required|integer|min:2',
            'taux' => 'nullable|numeric',
            'montant_taux' => 'nullable|numeric',
            'organisateur_id' => 'required|exists:membres,id',
        ]);

        Tontine::create($request->all());
        return redirect()->route('tontines.index')->with('success', 'Tontine créée.');
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
}
