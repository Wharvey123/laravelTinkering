<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\CarController;

// Ruta principal
Route::get('/', function () {
    return view('index');
})->name('home'); // Assignem el nom 'home'

// Rutes per a Films
Route::get('/films', [FilmController::class, 'index'])->name('films.index'); // Llistar totes les pel·lícules
Route::get('/films/create', [FilmController::class, 'create'])->name('films.create'); // Formulari per crear una pel·lícula
Route::post('/films', [FilmController::class, 'store'])->name('films.store'); // Guardar nova pel·lícula
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show'); // Veure una pel·lícula específica
Route::get('/films/{film}/edit', [FilmController::class, 'edit'])->name('films.edit'); // Formulari per editar una pel·lícula
Route::put('/films/{film}', [FilmController::class, 'update'])->name('films.update'); // Actualitzar una pel·lícula
Route::get('/films/{film}/delete', [FilmController::class, 'confirmDelete'])->name('films.confirmDelete'); // Confirmació d'eliminació
Route::delete('/films/{film}', [FilmController::class, 'destroy'])->name('films.destroy'); // Eliminar una pel·lícula

// Rutes per a Cars
Route::get('/cars', [CarController::class, 'index'])->name('cars.index'); // Llistar tots els cotxes
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create'); // Formulari per crear un cotxe
Route::post('/cars', [CarController::class, 'store'])->name('cars.store'); // Guardar nou cotxe
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show'); // Veure un cotxe específic
Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit'); // Formulari per editar un cotxe
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update'); // Actualitzar un cotxe
Route::get('/cars/{car}/delete', [CarController::class, 'confirmDelete'])->name('cars.confirmDelete'); // Confirmació d'eliminació
Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy'); // Eliminar un cotxe
