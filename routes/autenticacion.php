<?php

use App\Http\Controllers\Autenticacion\SesionAutenticadaController;
use App\Http\Controllers\Autenticacion\UsuarioRegistradoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [UsuarioRegistradoController::class, 'create'])
        ->name('register');

    Route::post('register', [UsuarioRegistradoController::class, 'store']);

    Route::get('login', [SesionAutenticadaController::class, 'create'])
        ->name('login');

    Route::post('login', [SesionAutenticadaController::class, 'store']);

});

Route::middleware('auth')->group(function () {
    Route::post('logout', [SesionAutenticadaController::class, 'destroy'])
        ->name('logout');
});
