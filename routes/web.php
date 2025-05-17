<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\RegistroInmuebleController;
use App\Models\RegistroInmueble;
use App\Http\Controllers\DeleteInmuebleController;
use App\Http\Controllers\EditInmuebleController;
use App\Http\Controllers\PageInmuebleController;
use App\Models\User;
use App\Http\Controllers\GestionAdminController;
use App\Http\Controllers\DeleteUserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $inmuevles = RegistroInmueble::all();
    return view('dashboard')->with('inmuevles', $inmuevles);
})->name('dashboard');

Route::get('/misInmuebles', function () {
    return view('CreateInmueble');
})->middleware(['auth', 'verified'])->name('CreateInmueble.blade');

Route::get('/GestionarInmuebles', function () {
    $inmuebles = RegistroInmueble::where('user_id', auth()->id())
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
    return view('GestionarInmuebles')->with('inmuebles', $inmuebles);
})->middleware(['auth', 'verified'])->name('GestionarInmuebles.blade');


Route::get('/EditInmueble', function () {
    return view('EditInmueble');
})->middleware(['auth', 'verified'])->name('EditInmueble.blade');

Route::get('/GestionarUsuarios', function () {
    $users = User::all();
    return view('GestionarUsuarios')->with('users', $users);
})->middleware(['auth', 'verified'])->middleware('admin')->name('GestionarUsuarios');

Route::get('/CarritoView', function () {
    return view('CarritoView');
})->middleware(['auth', 'verified'])->name('Carrito.View');

Route::get('/VentasView', function () {
    return view('VentasView');
})->middleware(['auth', 'verified'])->name('Ventas.View');

Route::get('/inmuebles/{inmueble}/editar', [EditInmuebleController::class, 'edit'])->name('inmuebles.edit');
Route::put('/User/{user}', [GestionAdminController::class, 'GestionarAdmin'])->middleware('admin')->name('User.Admin');
Route::delete('/User/{user_id}', [DeleteUserController::class, 'destroy'])->middleware('admin')->name('User.Delete');
Route::put('/inmuebles/{inmueble}', [EditInmuebleController::class, 'update'])->name('inmuebles.update');
Route::delete('/inmuebles/{inmueble}', [DeleteInmuebleController::class, 'destroy'])->name('inmuebles.destroy');
Route::get('/registro-inmueble/create', [RegistroInmuebleController::class, 'create'])->name('registro-inmueble.create');
Route::post('/registro-inmueble', [RegistroInmuebleController::class, 'store'])->name('registro-inmueble.store');
Route::get('/inmuebles/{inmueble}', [PageInmuebleController::class, 'show'])->name('Page');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
