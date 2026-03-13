<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\MetaFinancieraController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ConfiguracionController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transacciones
    Route::resource('transacciones', TransaccionController::class);

    // Presupuestos
    Route::resource('presupuestos', PresupuestoController::class);

    // Metas financieras
    Route::resource('metas', MetaFinancieraController::class);

    // Facturas
    Route::resource('facturas', FacturaController::class);

    // Configuración del usuario
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');

});

// Rutas de autenticación 
require __DIR__.'/auth.php';
