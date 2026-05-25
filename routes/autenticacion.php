<?php

use App\Http\Controllers\Autenticacion\SesionAutenticadaController;
use App\Http\Controllers\Autenticacion\ConfirmacionContrasenaController;
use App\Http\Controllers\Autenticacion\NotificacionVerificacionEmailController;
use App\Http\Controllers\Autenticacion\SolicitudVerificacionEmailController;
use App\Http\Controllers\Autenticacion\NuevaContrasenaController;
use App\Http\Controllers\Autenticacion\ContrasenaController;
use App\Http\Controllers\Autenticacion\EnlaceRestablecerContrasenaController;
use App\Http\Controllers\Autenticacion\UsuarioRegistradoController;
use App\Http\Controllers\Autenticacion\VerificarEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [UsuarioRegistradoController::class, 'create'])
        ->name('register');

    Route::post('register', [UsuarioRegistradoController::class, 'store']);

    Route::get('login', [SesionAutenticadaController::class, 'create'])
        ->name('login');

    Route::post('login', [SesionAutenticadaController::class, 'store']);

    Route::get('olvide-contrasena', [EnlaceRestablecerContrasenaController::class, 'create'])
        ->name('password.request');
    Route::get('forgot-password', [EnlaceRestablecerContrasenaController::class, 'create']);

    Route::post('olvide-contrasena', [EnlaceRestablecerContrasenaController::class, 'store'])
        ->name('password.email');
    Route::post('forgot-password', [EnlaceRestablecerContrasenaController::class, 'store']);

    Route::get('restablecer-contrasena/{token}', [NuevaContrasenaController::class, 'create'])
        ->name('password.reset');
    Route::get('reset-password/{token}', [NuevaContrasenaController::class, 'create']);

    Route::post('restablecer-contrasena', [NuevaContrasenaController::class, 'store'])
        ->name('password.store');
    Route::post('reset-password', [NuevaContrasenaController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('verificar-email', SolicitudVerificacionEmailController::class)
        ->name('verification.notice');
    Route::get('verify-email', SolicitudVerificacionEmailController::class);

    Route::get('verificar-email/{id}/{hash}', VerificarEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/notificacion-verificacion', [NotificacionVerificacionEmailController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirmar-contrasena', [ConfirmacionContrasenaController::class, 'show'])
        ->name('password.confirm');
    Route::get('confirm-password', [ConfirmacionContrasenaController::class, 'show']);

    Route::post('confirmar-contrasena', [ConfirmacionContrasenaController::class, 'store']);
    Route::post('confirm-password', [ConfirmacionContrasenaController::class, 'store']);

    Route::put('contrasena', [ContrasenaController::class, 'update'])->name('password.update');
    Route::put('password', [ContrasenaController::class, 'update']);

    Route::post('logout', [SesionAutenticadaController::class, 'destroy'])
        ->name('logout');
});
