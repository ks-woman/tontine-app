<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MembreController;
use App\Http\Controllers\Admin\AnnonceController;
use App\Http\Controllers\Admin\CandidatureController;
use App\Http\Controllers\Admin\TontineParticipantController;
use App\Http\Controllers\Gestion\TontineController;
use App\Http\Controllers\Gestion\TourController;
use App\Http\Controllers\Gestion\CotisationController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Membre\DashboardController as MembreDashboard;
use App\Http\Controllers\Membre\ProfilController;
use App\Http\Controllers\Membre\MesTontinesController;
use App\Http\Controllers\Membre\MesCotisationsController;
use App\Http\Controllers\Membre\CandidatureController as MembreCandidatureController;
use App\Http\Controllers\Membre\CotisationController as MembreCotisationController;
use App\Http\Controllers\Membre\PaiementController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes publiques (annonces)
Route::get('/annonces', [PublicController::class, 'annonces'])->name('public.annonces');
Route::get('/annonce/{annonce}', [PublicController::class, 'showAnnonce'])->name('public.annonce.show');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // ==================== ADMIN ROUTES ====================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('membres', MembreController::class);
        Route::resource('annonces', AnnonceController::class);
        Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::post('/candidatures/{candidature}/accepter', [CandidatureController::class, 'accepter'])->name('candidatures.accepter');
        Route::post('/candidatures/{candidature}/rejeter', [CandidatureController::class, 'rejeter'])->name('candidatures.rejeter');

        // Exports PDF
        Route::get('/export/cotisations', [ExportController::class, 'allCotisations'])->name('export.cotisations');
        Route::get('/export/membre/{membre}/cotisations', [ExportController::class, 'membreCotisations'])->name('export.membre.cotisations');
        Route::get('/export/tontine/{id}/cotisations', [ExportController::class, 'tontineCotisations'])->name('export.tontine.cotisations');

        // Validation des paiements
        Route::post('/cotisations/{cotisation}/confirmer', [CotisationController::class, 'confirmer'])->name('cotisations.confirmer');
        Route::post('/cotisations/{cotisation}/rejeter', [CotisationController::class, 'rejeter'])->name('cotisations.rejeter');
    });

    // ==================== GESTION DES PARTICIPANTS (accessible aux organisateurs) ====================
    Route::get('/tontines/{tontine}/participants', [TontineParticipantController::class, 'index'])->name('tontines.participants.index');
    Route::post('/tontines/{tontine}/participants', [TontineParticipantController::class, 'store'])->name('tontines.participants.store');
    Route::delete('/tontines/{tontine}/participants/{membre}', [TontineParticipantController::class, 'destroy'])->name('tontines.participants.destroy');
    Route::post('/tontines/{tontine}/regenerer-tours', [TontineController::class, 'regenererTours'])->name('tontines.regenerer-tours');

    // ==================== GESTION DES URGENCES (ADMIN) ====================
    // Liste des demandes d'urgence en attente
    Route::get('/urgences', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'index'])->name('admin.urgences.index');

    // Valider une demande d'urgence (déclenche le tour immédiat)
    Route::post('/urgences/{urgence}/valider', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'valider'])->name('admin.urgences.valider');

    // Rejeter une demande d'urgence
    Route::post('/urgences/{urgence}/rejeter', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'rejeter'])->name('admin.urgences.rejeter');

    // ==================== MEMBRE SIMPLE ROUTES ====================
    Route::get('/membre/dashboard', [MembreDashboard::class, 'index'])->name('membre.dashboard');
    Route::get('/membre/profil', [ProfilController::class, 'edit'])->name('membre.profil.edit');
    Route::put('/membre/profil', [ProfilController::class, 'update'])->name('membre.profil.update');
    Route::get('/membre/mes-tontines', [MesTontinesController::class, 'index'])->name('membre.mes_tontines');
    Route::get('/membre/mes-cotisations', [MesCotisationsController::class, 'index'])->name('membre.mes_cotisations');
    Route::get('/membre/cotiser/{tontine}', [MembreCotisationController::class, 'create'])->name('membre.cotiser.create');
    Route::post('/membre/cotiser', [MembreCotisationController::class, 'store'])->name('membre.cotiser.store');
    Route::post('/membre/urgence/{tontine}', [App\Http\Controllers\Membre\UrgenceController::class, 'demander'])->name('membre.urgence.demander');

    // Paiement en ligne
    Route::get('/membre/paiement/{tontine}', [PaiementController::class, 'form'])->name('membre.paiement.form');
    Route::post('/membre/paiement', [PaiementController::class, 'store'])->name('membre.paiement.store');

    // Candidatures (membre)
    Route::post('/candidature/{annonce}', [MembreCandidatureController::class, 'store'])->name('membre.candidature.store');
    Route::get('/membre/mes-candidatures', [MembreCandidatureController::class, 'mesCandidatures'])->name('membre.mes_candidatures');

    // ==================== CRUD PRINCIPAUX ====================
    Route::resource('tontines', TontineController::class);
    Route::resource('tours', TourController::class);
    Route::resource('cotisations', CotisationController::class);
});
