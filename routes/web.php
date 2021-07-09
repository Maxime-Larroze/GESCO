<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\PDFController;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', [DashboardController::class, 'autoLogin'])->name('home');
    Route::post('public/login', [DashboardController::class, 'login'])->name('login');

    Route::get('public/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback.google');
    Route::get('public/google', [GoogleController::class, 'redirectToGoogle'])->name('register.google');

    Route::get('public/github/callback', [GithubController::class, 'handleGithubCallback'])->name('callback.github');
    Route::get('public/github', [GithubController::class, 'redirectToGithub'])->name('register.github');

    Route::get('public/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('callback.facebook');
    Route::get('public/facebook', [FacebookController::class, 'redirectToFacebook'])->name('register.facebook');
});


Route::middleware(['auth'])->group(function () {
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

        Route::get('/factures', [FactureController::class, 'show'])->name('factures.show');
        Route::get('/factures/generate/{id}', [PDFController::class, 'show'])->name('factures.pdf.show');
        Route::get('/factures/generate/{id}/download', [PDFController::class, 'store'])->name('factures.pdf.store');

        Route::get('/parametres', [ParametreController::class, 'show'])->name('parametres.show');
        Route::post('/parametres', [ParametreController::class, 'store'])->name('parametres.store');
        Route::put('/parametres', [ParametreController::class, 'update'])->name('parametres.update');

        Route::post('/email/facture/envoie', [MailController::class, 'sendToClient'])->name('email.facture.send');
    });
});

Route::middleware('signed')->group(function(){
    Route::get('public/telechargement/facture/{user_id}/{id}', [PDFController::class, 'externalDownloadSigned'])->name('signed.exeternal.facture');
});

Route::get('/404', [DashboardController::class, 'error404'])->name('error.404');
Route::get('/403', [DashboardController::class, 'error403'])->name('error.403');