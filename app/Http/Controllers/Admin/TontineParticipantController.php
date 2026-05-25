<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use App\Models\Membre;
use Illuminate\Http\Request;

class TontineParticipantController extends Controller
{
    public function index(Tontine $tontine)
    {
        $participants = $tontine->membresParticipants ?? collect();
        $membresDisponibles = Membre::whereNotIn('id', $participants->pluck('id'))->get();
        return view('admin.tontines.participants', compact('tontine', 'participants', 'membresDisponibles'));
    }

    public function store(Request $request, Tontine $tontine)
    {
        $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'role' => 'required|in:organisateur,coorganisateur,participant',
        ]);

        $tontine->membresParticipants()->attach($request->membre_id, ['role' => $request->role]);

        return back()->with('success', 'Membre ajouté.');
    }

    public function destroy(Tontine $tontine, Membre $membre)
    {
        $tontine->membresParticipants()->detach($membre->id);
        return back()->with('success', 'Participant retiré.');
    }
}
