<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\MetaFinancieraController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\EducacionController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CompartidoController;
use App\Http\Controllers\PresupuestoDetalleCategoriaController;


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

    // Sobres personalizados
    Route::get('/presupuestos/{presupuesto}/sobres/create', [PresupuestoDetalleCategoriaController::class, 'create'])
        ->name('presupuestos.sobres.create');

    Route::post('/presupuestos/{presupuesto}/sobres', [PresupuestoDetalleCategoriaController::class, 'store'])
        ->name('presupuestos.sobres.store');

    Route::get('/sobres/{detalle}/edit', [PresupuestoDetalleCategoriaController::class, 'edit'])
        ->name('sobres.edit');

    Route::put('/sobres/{detalle}', [PresupuestoDetalleCategoriaController::class, 'update'])
        ->name('sobres.update');

    Route::delete('/sobres/{detalle}', [PresupuestoDetalleCategoriaController::class, 'destroy'])
        ->name('sobres.destroy');
        
    // Metas financieras
    Route::resource('metas', MetaFinancieraController::class);

    // Facturas
    Route::resource('facturas', FacturaController::class);

    // Asistente financiero
    Route::get('/asistente', [AsistenteController::class, 'index'])->name('asistente.index');

    // Educación financiera
    Route::get('/educacion', [EducacionController::class, 'index'])->name('educacion.index');

    // Calendario financiero
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    // Cuenta compartida
    Route::get('/compartido', [CompartidoController::class, 'index'])->name('compartido.index');

    // Configuración del usuario
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');
});

// Rutas de autenticación
require __DIR__ . '/auth.php';