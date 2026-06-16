<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Tour;
use App\Models\Urgence;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $membre = $user->membre;

        // Total cotisé
        $totalCotise = $membre->cotisations()->sum('montant');

        // Nombre de tontines auxquelles il participe
        $nbParticipations = $membre->tontinesParticipant()->count()
            + $membre->tontinesCoOrganisees()->count()
            + $membre->tontinesOrganisees()->count();

        // Prochain tour où il est bénéficiaire
        $prochainTour = Tour::with(['membre', 'tontine'])
            ->where('membre_id', $membre->id)
            ->where('statut', 'planifie')
            ->orderBy('ordre')
            ->first();


        if ($prochainTour && $prochainTour->tontine) {
            $montantTour = $prochainTour->tontine->montant_total / $prochainTour->tontine->nbr_personne;
        } else {
            $montantTour = null;
        }

        // Ajout : bénéficiaire et montant du prochain tour
        $prochainBeneficiaire = null;
        $montantTour = 0;
        if ($prochainTour) {
            $prochainBeneficiaire = $prochainTour->membre;

            // Sécuriser le cas où un tour pointe vers une tontine inexistante ou supprimée.
            if ($prochainTour->tontine) {
                $nombreParticipants = max((int) $prochainTour->tontine->nbr_personne, 1);
                $montantTour = $prochainTour->tontine->montant_total;
            }
        }

        // Évolution des cotisations (12 derniers mois)
        $evolution = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $montant = $membre->cotisations()
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('montant');
            $evolution[] = [
                'mois' => $date->format('M Y'),
                'montant' => $montant
            ];
        }
        $evolution = array_reverse($evolution);

        // Dernières notifications (3)
        $notifications = Notification::where('user_id', $user->id)->latest()->take(3)->get();

        // Demande d'urgence en attente
        $demandeUrgence = Urgence::where('membre_id', $membre->id)
            ->where('statut', 'en_attente')
            ->first();

        return view('membre.dashboard', compact(
            'membre',
            'totalCotise',
            'nbParticipations',
            'prochainTour',
            'prochainBeneficiaire',
            'montantTour',
            'evolution',
            'notifications',
            'demandeUrgence'
        ));
    }
}
