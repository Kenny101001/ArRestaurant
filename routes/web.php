<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('identification.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/scan/{id}', [App\Http\Controllers\ProductController::class, 'show']);


Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/loginVerifAdmin', [App\Http\Controllers\LoginController::class, 'loginVerifAdmin'])->name('loginVerifAdmin');

Route::get('/deco', [App\Http\Controllers\LoginController::class, 'deco'])->name('deco');


Route::get('/home', [App\Http\Controllers\AdminController::class, 'home'])->name('home');
Route::post('/ajouterEntreprise', [App\Http\Controllers\AdminController::class, 'ajouterEntreprise'])->name('ajouterEntreprise');
Route::get('/entrepriseDetail/{id}', [App\Http\Controllers\AdminController::class, 'entrepriseDetail'])->name('entrepriseDetail');
Route::post('/ajouterObjet3d', [App\Http\Controllers\AdminController::class, 'ajouterObjet3d'])->name('ajouterObjet3d');
Route::post('/modifierProduit/{id}', [App\Http\Controllers\AdminController::class, 'modifierProduit'])->name('modifierProduit');
Route::post('/supprimerProduit', [App\Http\Controllers\AdminController::class, 'supprimerProduit'])->name('supprimerProduit');

Route::get('/statistique', action: [App\Http\Controllers\StatistiqueController::class, 'statistique'])->name('statistique');

