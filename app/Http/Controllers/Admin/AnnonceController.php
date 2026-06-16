<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with('createur')->latest()->paginate(10);
        return view('admin.annonces.index', compact('annonces'));
    }

    public function create()
    {
        return view('admin.annonces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree_mois' => 'required|integer|min:1|max:60',
            'nombre_personnes' => 'required|integer|min:2|max:100',
            'montant_cotisation' => 'required|numeric|min:1000',
            'date_limite' => 'nullable|date|after:today',
            'tontine_id' => 'required|exists:tontines,id',
        ]);

        Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'duree_mois' => $request->duree_mois,
            'nombre_personnes' => $request->nombre_personnes,
            'montant_cotisation' => $request->montant_cotisation,
            'cree_par' => Auth::id(),
            'date_limite' => $request->date_limite,
            'statut' => 'active',
            'tontine_id' => $request->tontine_id,
        ]);

        return redirect()->route('admin.annonces.index')->with('success', 'Annonce publiée avec succès.');
    }

    public function show(Annonce $annonce)
    {
        return view('admin.annonces.show', compact('annonce'));
    }

    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('admin.annonces.edit', compact('annonce'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree_mois' => 'required|integer|min:1|max:60',
            'nombre_personnes' => 'required|integer|min:2|max:100',
            'montant_cotisation' => 'required|numeric|min:1000',
            'date_limite' => 'nullable|date|after:today',
            'statut' => 'required|in:active,cloturee,annulee',
            'tontine_id' => 'required|exists:tontines,id',
        ]);

        $annonce->update($request->all());
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce supprimée.');
    }
}
