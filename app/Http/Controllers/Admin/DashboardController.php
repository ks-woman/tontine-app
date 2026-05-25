<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Tontine;
use App\Models\Tour;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $stats = [
            'total_membres' => Membre::count(),
            'total_tontines' => Tontine::count(),
            'total_tours' => Tour::count(),
            'total_cotisations' => Cotisation::sum('montant'),
            'membres_mois' => Membre::whereMonth('date_adhesion', Carbon::now()->month)->count(),
            'cotisations_mois' => Cotisation::whereMonth('date', Carbon::now()->month)->sum('montant'),
        ];

        // Évolution des cotisations (12 derniers mois)
        $evolution = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $total = Cotisation::whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('montant');
            $evolution[] = [
                'mois' => $month,
                'total' => $total
            ];
        }
        $evolution = array_reverse($evolution);

        // Dernières activités
        $dernieres_cotisations = Cotisation::with(['membre', 'tontine'])
            ->latest()
            ->take(10)
            ->get();

        // Tontines actives
        $tontines_actives = Tontine::with('organisateur')
            ->latest()
            ->take(5)
            ->get();

        // Top membres cotisants
        $top_membres = Cotisation::select('membre_id', DB::raw('SUM(montant) as total_cotise'))
            ->with('membre')
            ->groupBy('membre_id')
            ->orderBy('total_cotise', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'evolution', 'dernieres_cotisations', 'tontines_actives', 'top_membres'));
    }
}
