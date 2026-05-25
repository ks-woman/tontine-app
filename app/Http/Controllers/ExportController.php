<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export de toutes les cotisations (admin)
    public function allCotisations()
    {
        $cotisations = Cotisation::with(['membre', 'tontine'])->latest()->get();
        $total = $cotisations->sum('montant');

        $pdf = Pdf::loadView('exports.cotisations', compact('cotisations', 'total'));
        return $pdf->download('toutes_les_cotisations.pdf');
    }

    // Export des cotisations d'un membre spécifique
    public function membreCotisations(Membre $membre)
    {
        $cotisations = $membre->cotisations()->with('tontine')->latest()->get();
        $total = $cotisations->sum('montant');

        $pdf = Pdf::loadView('exports.cotisations_membre', compact('cotisations', 'total', 'membre'));
        return $pdf->download('cotisations_' . $membre->nom . '.pdf');
    }

    // Export des cotisations par tontine
    public function tontineCotisations($id)
    {
        $tontine = \App\Models\Tontine::findOrFail($id);
        $cotisations = $tontine->cotisations()->with('membre')->latest()->get();
        $total = $cotisations->sum('montant');

        $pdf = Pdf::loadView('exports.cotisations_tontine', compact('cotisations', 'total', 'tontine'));
        return $pdf->download('cotisations_tontine_' . $tontine->id . '.pdf');
    }
}
