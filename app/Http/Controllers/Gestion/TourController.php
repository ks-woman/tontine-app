<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Tontine;
use App\Models\Membre;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with(['tontine', 'membre'])->latest()->paginate(10);
        return view('tours.index', compact('tours'));
    }

    public function create()
    {
        $tontines = Tontine::all();
        $membres = Membre::all();
        return view('tours.create', compact('tontines', 'membres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ordre' => 'required|integer|min:1',
            'tontine_id' => 'required|exists:tontines,id',
            'membre_id' => 'required|exists:membres,id',
        ]);

        // Vérifier unicité (tontine_id, ordre)
        $exists = Tour::where('tontine_id', $request->tontine_id)
            ->where('ordre', $request->ordre)
            ->exists();
        if ($exists) {
            return back()->withErrors(['ordre' => 'Cet ordre existe déjà pour cette tontine.'])->withInput();
        }

        Tour::create($request->all());
        return redirect()->route('tours.index')->with('success', 'Tour ajouté avec succès.');
    }

    public function show(Tour $tour)
    {
        return view('tours.show', compact('tour'));
    }

    public function edit(Tour $tour)
    {
        $tontines = Tontine::all();
        $membres = Membre::all();
        return view('tours.edit', compact('tour', 'tontines', 'membres'));
    }

    public function update(Request $request, Tour $tour)
    {
        $request->validate([
            'ordre' => 'required|integer|min:1',
            'tontine_id' => 'required|exists:tontines,id',
            'membre_id' => 'required|exists:membres,id',
        ]);

        $exists = Tour::where('tontine_id', $request->tontine_id)
            ->where('ordre', $request->ordre)
            ->where('id', '!=', $tour->id)
            ->exists();
        if ($exists) {
            return back()->withErrors(['ordre' => 'Cet ordre existe déjà pour cette tontine.'])->withInput();
        }

        $tour->update($request->all());
        return redirect()->route('tours.index')->with('success', 'Tour mis à jour.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('tours.index')->with('success', 'Tour supprimé.');
    }
}
