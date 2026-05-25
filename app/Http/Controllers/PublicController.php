<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function annonces()
    {
        $annonces = Annonce::where('statut', 'active')
            ->where(function ($q) {
                $q->whereNull('date_limite')->orWhere('date_limite', '>=', now());
            })
            ->latest()
            ->paginate(9);

        return view('public.annonces', compact('annonces'));
    }

    public function showAnnonce(Annonce $annonce)
    {
        // Vérifier si l'annonce est visible (active et date limite non dépassée)
        if ($annonce->statut !== 'active' || ($annonce->date_limite && $annonce->date_limite < now())) {
            abort(404, 'Annonce non disponible');
        }

        return view('public.annonce_show', compact('annonce'));
    }
}
