<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MembreController;
use App\Http\Controllers\Admin\AnnonceController;
use App\Http\Controllers\Admin\CandidatureController;
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
use App\Http\Controllers\Admin\TontineParticipantController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes publiques (annonces)
Route::get('/annonces', [PublicController::class, 'annonces'])->name('public.annonces');
Route::get('/annonce/{annonce}', [PublicController::class, 'showAnnonce'])->name('public.annonce.show');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('membres', MembreController::class);
        Route::resource('annonces', AnnonceController::class);
        Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::post('/candidatures/{candidature}/accepter', [CandidatureController::class, 'accepter'])->name('candidatures.accepter');
        Route::post('/candidatures/{candidature}/rejeter', [CandidatureController::class, 'rejeter'])->name('candidatures.rejeter');
        Route::get('/tontines/{tontine}/participants', [TontineParticipantController::class, 'index'])->name('tontines.participants.index');
        Route::post('/tontines/{tontine}/participants', [TontineParticipantController::class, 'store'])->name('tontines.participants.store');
        Route::delete('/tontines/{tontine}/participants/{membre}', [TontineParticipantController::class, 'destroy'])->name('tontines.participants.destroy');
    });

    // Membre simple
    Route::get('/membre/dashboard', [MembreDashboard::class, 'index'])->name('membre.dashboard');
    Route::get('/membre/profil', [ProfilController::class, 'edit'])->name('membre.profil.edit');
    Route::put('/membre/profil', [ProfilController::class, 'update'])->name('membre.profil.update');
    Route::get('/membre/mes-tontines', [MesTontinesController::class, 'index'])->name('membre.mes_tontines');
    Route::get('/membre/mes-cotisations', [MesCotisationsController::class, 'index'])->name('membre.mes_cotisations');
    Route::get('/membre/cotiser/{tontine}', [MembreCotisationController::class, 'create'])->name('membre.cotiser.create');
    Route::post('/membre/cotiser', [MembreCotisationController::class, 'store'])->name('membre.cotiser.store');

    // Candidatures (membre)
    Route::post('/candidature/{annonce}', [MembreCandidatureController::class, 'store'])->name('membre.candidature.store');
    Route::get('/membre/mes-candidatures', [MembreCandidatureController::class, 'mesCandidatures'])->name('membre.mes_candidatures');

    // Gestion CRUD
    Route::resource('tontines', TontineController::class);
    Route::resource('tours', TourController::class);
    Route::resource('cotisations', CotisationController::class);

    // Validation des paiements (admin)
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::post('/cotisations/{cotisation}/confirmer', [CotisationController::class, 'confirmer'])->name('cotisations.confirmer');
        Route::post('/cotisations/{cotisation}/rejeter', [CotisationController::class, 'rejeter'])->name('cotisations.rejeter');
        Route::get('/export/cotisations', [ExportController::class, 'allCotisations'])->name('export.cotisations');
        Route::get('/export/membre/{membre}/cotisations', [ExportController::class, 'membreCotisations'])->name('export.membre.cotisations');
        Route::get('/export/tontine/{id}/cotisations', [ExportController::class, 'tontineCotisations'])->name('export.tontine.cotisations');
    });
});
