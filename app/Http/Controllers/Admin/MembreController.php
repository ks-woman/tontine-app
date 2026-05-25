<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MembreController extends Controller
{
    public function index()
    {
        $membres = Membre::with('user')->latest()->paginate(10);
        return view('admin.membres.index', compact('membres'));
    }

    public function create()
    {
        return view('admin.membres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:membres,email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'numero_piece_identite' => 'required|string|unique:membres',
            'adresse' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->prenom . ' ' . $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        Membre::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'numero_piece_identite' => $request->numero_piece_identite,
            'adresse' => $request->adresse,
            'date_adhesion' => now(),
        ]);

        return redirect()->route('admin.membres.index')->with('success', 'Membre créé.');
    }

    public function show(Membre $membre)
    {
        return view('admin.membres.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        return view('admin.membres.edit', compact('membre'));
    }

    public function update(Request $request, Membre $membre)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'adresse' => 'nullable|string',
        ]);

        $membre->update($request->only(['nom', 'prenom', 'telephone', 'date_naissance', 'lieu_naissance', 'adresse']));
        $membre->user->update(['name' => $request->prenom . ' ' . $request->nom]);

        if ($request->filled('password')) {
            $membre->user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.membres.index')->with('success', 'Membre mis à jour.');
    }

    public function destroy(Membre $membre)
    {
        if ($membre->tontinesOrganisees()->count() > 0) {
            return back()->with('error', 'Impossible : ce membre organise une tontine.');
        }
        $membre->user->delete();
        $membre->delete();
        return redirect()->route('admin.membres.index')->with('success', 'Membre supprimé.');
    }
}
