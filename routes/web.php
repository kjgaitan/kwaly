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
use App\Http\Controllers\LeccionEducativaController;
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

    Route::patch('/facturas/{id}/pagar', [FacturaController::class, 'marcarPagada'])
    ->name('facturas.pagar');

    // Asistente financiero
    Route::get('/asistente', [AsistenteController::class, 'index'])->name('asistente.index');

    // Educación financiera
    Route::get('/educacion', [EducacionController::class, 'index'])->name('educacion.index');

    Route::post('/educacion/completar/{id}', [EducacionController::class, 'completar'])
    ->name('educacion.completar');

    Route::resource('modulos-educativos', ModuloEducativoController::class)
    ->except(['show']);

      // Leccion Educativa
    Route::get('/modulos-educativos/{modulo}/lecciones', [LeccionEducativaController::class, 'index'])
    ->name('modulos-educativos.lecciones.index');

    Route::get('/modulos-educativos/{modulo}/lecciones/create', [LeccionEducativaController::class, 'create'])
        ->name('modulos-educativos.lecciones.create');

    Route::post('/modulos-educativos/{modulo}/lecciones', [LeccionEducativaController::class, 'store'])
        ->name('modulos-educativos.lecciones.store');

    Route::get('/modulos-educativos/{modulo}/lecciones/{leccion}/edit', [LeccionEducativaController::class, 'edit'])
        ->name('modulos-educativos.lecciones.edit');

    Route::put('/modulos-educativos/{modulo}/lecciones/{leccion}', [LeccionEducativaController::class, 'update'])
        ->name('modulos-educativos.lecciones.update');

    Route::delete('/modulos-educativos/{modulo}/lecciones/{leccion}', [LeccionEducativaController::class, 'destroy'])
        ->name('modulos-educativos.lecciones.destroy');

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