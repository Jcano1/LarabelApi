<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\RegistroInmuebleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/misInmuebles', function () {
    return view('CreateInmueble');
})->middleware(['auth', 'verified'])->name('CreateInmueble.blade');






Route::middleware('auth')->group(function () {
    Route::get('/registro-inmueble/create', [RegistroInmuebleController::class, 'create'])->name('registro-inmueble.create');
    Route::post('/registro-inmueble', [RegistroInmuebleController::class, 'store'])->name('registro-inmueble.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
