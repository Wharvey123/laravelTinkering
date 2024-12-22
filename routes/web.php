<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\CarController;

// Ruta principal - Ruta per la pàgina d'inici
Route::get('/', function () {
    return view('index');
})->name('home'); // Ruta anomenada 'home'

// Rutes de recursos per a Films
// La següent línia genera totes les rutes per al FilmController automàticament:
// - index, create, store, show, edit, update, destroy
Route::resource('films', FilmController::class); // Utilitzant Route::resource() per al FilmController
// Ruta personalitzada per a la confirmació d'eliminació
Route::get('/films/{film}/delete', [FilmController::class, 'confirmDelete'])->name('films.confirmDelete');

// Rutes de recursos per a Cars
// La següent línia genera totes les rutes per al CarController automàticament:
// - index, create, store, show, edit, update, destroy
Route::resource('cars', CarController::class); // Utilitzant Route::resource() per al CarController
// Ruta personalitzada per a la confirmació d'eliminació
Route::get('/cars/{car}/delete', [CarController::class, 'confirmDelete'])->name('cars.confirmDelete');
