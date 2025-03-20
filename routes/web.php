<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GestionnaireController;


Route::get('/', function () {
    return view('auth/login');
});

Route::get('/connex', function () {
    return view('auth.login');
})->middleware(['auth', 'verified'])->name('connex');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//notification et mail
Route::prefix('commandes')->group(function () {
    Route::post('/{commande}/confirmer', [CommandeController::class, 'confirmerCommande'])->name('commandes.confirmer');
    Route::post('/{commande}/facture', [CommandeController::class, 'factureCommande'])->name('commandes.facture');
    Route::post('/{commande}/notifier-prete', [CommandeController::class, 'notifierCommandePrete'])->name('commandes.notifierPrete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



        // Dashboard
        Route::get('/dashboard2', [DashboardController::class, 'index'])->name('dashboard2');

        Route::get('/dasboardClient', [ClientController::class, 'index'])->name('dasboardClient');

        Route::get('/dasboardGestionnaire', [GestionnaireController::class, 'index'])->name('dasboardGestionnaire');

        // Routes pour les clients
        Route::get('/catalogue', [BurgerController::class, 'catalogue'])
        ->name('catalogue');


        Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes'])
        ->name('mes-commandes');


    Route::get('/commandes/en-cours', [CommandeController::class, 'commandesEnCours'])
        ->name('commandes.en-cours');


    Route::resource('commandes', CommandeController::class);


         // Routes pour les gestionnaires Route::middleware(['role:gestionnaire'])->group(function () {  });


        Route::resource('burgers', BurgerController::class);


        Route::post('/commandes/{commande}/paiement', [PaiementController::class, 'store'])
        ->name('commandes.paiement.store');


        Route::resource('paiements', PaiementController::class);


        Route::get('/statistiques', [StatistiqueController::class, 'index'])
        ->name('statistiques');

        Route::patch('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])
        ->name('commandes.update-statut');


});

require __DIR__.'/auth.php';
