<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/statistique', action: [App\Http\Controllers\StatistiqueController::class, 'statistique'])->name('statistique');

