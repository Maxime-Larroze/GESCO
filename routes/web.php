<?php

use App\Http\Controllers\AccompteController;
use App\Http\Controllers\ContributionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [DashboardController::class, 'autoLogin'])->name('home');
    Route::post('public/login', [DashboardController::class, 'login'])->name('login');

    Route::get('public/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback.google');
    Route::get('public/google', [GoogleController::class, 'redirectToGoogle'])->name('register.google');

    Route::get('public/github/callback', [GithubController::class, 'handleGithubCallback'])->name('callback.github');
    Route::get('public/github', [GithubController::class, 'redirectToGithub'])->name('register.github');

    Route::get('public/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('callback.facebook');
    Route::get('public/facebook', [FacebookController::class, 'redirectToFacebook'])->name('register.facebook');
});


Route::middleware('auth')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
        Route::get('/profil', [UserController::class, 'showProfil'])->name('profil');

        Route::get('/organisations', [OrganisationController::class, 'show'])->name('organisations.show');
        Route::delete('/organisations', [OrganisationController::class, 'destroy'])->name('organisations.destroy');
        Route::put('/organisations', [OrganisationController::class, 'update'])->name('organisations.update');
        Route::post('/organisations', [OrganisationController::class, 'create'])->name('organisations.create');

        Route::get('/missions', [MissionController::class, 'show'])->name('missions.show');
        Route::delete('/missions', [MissionController::class, 'destroy'])->name('missions.destroy');
        Route::put('/missions', [MissionController::class, 'update'])->name('missions.update');
        Route::post('/missions', [MissionController::class, 'create'])->name('missions.create');

        Route::get('/parametres', [ParametreController::class, 'show'])->name('parametres.show');
        Route::post('/parametres', [ParametreController::class, 'store'])->name('parametres.store');
        Route::put('/parametres', [ParametreController::class, 'update'])->name('parametres.update');

        Route::get('/transactions', [TransactionController::class, 'show'])->name('transactions.show');
        Route::post('/transactions', [TransactionController::class, 'create'])->name('transactions.create');
        Route::put('/transactions', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions', [TransactionController::class, 'destroy'])->name('transactions.destroy');

        Route::get('/contributions', [ContributionController::class, 'show'])->name('contributions.show');
        Route::post('/contributions', [ContributionController::class, 'create'])->name('contributions.create');
        Route::put('/contributions', [ContributionController::class, 'update'])->name('contributions.update');
        Route::delete('/contributions', [ContributionController::class, 'destroy'])->name('contributions.destroy');


        Route::get('/factures', [FactureController::class, 'show'])->name('factures.show');
        Route::get('/devis', [DevisController::class, 'show'])->name('devis.show');
        Route::get('/factures-accomptes', [AccompteController::class, 'show'])->name('accomptes.show');
        
        Route::get('/factures/generate/{id}', [PDFController::class, 'showFacture'])->name('factures.pdf.show');
        Route::get('/factures/generate/{id}/download', [PDFController::class, 'factureStore'])->name('factures.pdf.store');
        Route::post('/email/facture/envoie', [MailController::class, 'factureSendToClient'])->name('email.facture.send');

        Route::get('/devis/generate/{id}', [PDFController::class, 'showDevis'])->name('devis.pdf.show');
        Route::get('/devis/generate/{id}/download', [PDFController::class, 'devisStore'])->name('devis.pdf.store');
        Route::post('/email/devis/envoie', [MailController::class, 'devisSendToClient'])->name('email.devis.send');

        Route::get('/factures-accomptes/generate/{id}', [PDFController::class, 'showAccompte'])->name('accomptes.pdf.show');
        Route::get('/factures-accomptes/generate/{id}/download', [PDFController::class, 'accompteStore'])->name('accomptes.pdf.store');
        Route::post('/email/factures-accomptes/envoie', [MailController::class, 'AccompteSendToClient'])->name('email.accomptes.send');
    });
});

Route::middleware('signed')->group(function(){
    Route::get('public/telechargement/facture/{user_id}/{id}', [PDFController::class, 'externalFactureSigned'])->name('signed.exeternal.facture');
    Route::get('public/telechargement/devis/{user_id}/{id}', [PDFController::class, 'externalDevisSigned'])->name('signed.exeternal.devis');
    Route::get('public/telechargement/factures-accomptes/{user_id}/{id}', [PDFController::class, 'externalAccompteSigned'])->name('signed.exeternal.accompte');
});

Route::get('/404', [DashboardController::class, 'error404'])->name('error.404');
Route::get('/403', [DashboardController::class, 'error403'])->name('error.403');

Route::fallback(function() {
    return redirect()->route('dashboard');
});