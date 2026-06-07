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
use App\Http\Controllers\Membre\NotificationController;  // ← import pour les notifications

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== ROUTES PUBLIQUES ====================
Route::get('/annonces', [PublicController::class, 'annonces'])->name('public.annonces');
Route::get('/annonce/{annonce}', [PublicController::class, 'showAnnonce'])->name('public.annonce.show');

Auth::routes();

// ==================== ROUTES PROTÉGÉES PAR AUTHENTIFICATION ====================
Route::middleware(['auth'])->group(function () {

    // ---------- ADMIN ----------
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

    // ---------- GESTION DES PARTICIPANTS (accessible aux organisateurs) ----------
    Route::get('/tontines/{tontine}/participants', [TontineParticipantController::class, 'index'])->name('tontines.participants.index');
    Route::post('/tontines/{tontine}/participants', [TontineParticipantController::class, 'store'])->name('tontines.participants.store');
    Route::delete('/tontines/{tontine}/participants/{membre}', [TontineParticipantController::class, 'destroy'])->name('tontines.participants.destroy');
    Route::post('/tontines/{tontine}/regenerer-tours', [TontineController::class, 'regenererTours'])->name('tontines.regenerer-tours');

    // ---------- GESTION DES URGENCES (ADMIN) ----------
    Route::get('/urgences', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'index'])->name('admin.urgences.index');
    Route::post('/urgences/{urgence}/valider', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'valider'])->name('admin.urgences.valider');
    Route::post('/urgences/{urgence}/rejeter', [App\Http\Controllers\Admin\UrgenceAdminController::class, 'rejeter'])->name('admin.urgences.rejeter');

    // ---------- ESPACE MEMBRE ----------
    Route::prefix('membre')->name('membre.')->group(function () {

        // Dashboard et profil
        Route::get('/dashboard', [MembreDashboard::class, 'index'])->name('dashboard');
        Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

        // Tontines et cotisations
        Route::get('/mes-tontines', [MesTontinesController::class, 'index'])->name('mes_tontines');
        Route::get('/mes-cotisations', [MesCotisationsController::class, 'index'])->name('mes_cotisations');
        Route::get('/cotiser/{tontine}', [MembreCotisationController::class, 'create'])->name('cotiser.create');
        Route::post('/cotiser', [MembreCotisationController::class, 'store'])->name('cotiser.store');

        // Urgence
        Route::post('/urgence/{tontine}', [App\Http\Controllers\Membre\UrgenceController::class, 'demander'])->name('urgence.demander');

        // Paiement en ligne
        Route::get('/paiement/{tontine}', [PaiementController::class, 'form'])->name('paiement.form');
        Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');

        // Candidatures
        Route::post('/candidature/{annonce}', [MembreCandidatureController::class, 'store'])->name('candidature.store');
        Route::get('/mes-candidatures', [MembreCandidatureController::class, 'mesCandidatures'])->name('mes_candidatures');

        // ========== NOTIFICATIONS (page dédiée) ==========
        // Liste des notifications (avec pagination)
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

        // Marquer une notification spécifique comme lue
        Route::post('/notifications/marquer/{id}', [NotificationController::class, 'marquer'])->name('notifications.marquer');

        // Marquer toutes les notifications comme lues
        Route::post('/notifications/marquer-tout', [NotificationController::class, 'marquerTout'])->name('notifications.marquer-tout');
    });

    // ---------- CRUD PRINCIPAUX (toutes les routes ressource) ----------
    Route::resource('tontines', TontineController::class);
    Route::resource('tours', TourController::class);
    Route::resource('cotisations', CotisationController::class);
});
