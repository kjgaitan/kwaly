<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\MetaFinancieraController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\EducacionController;
use App\Http\Controllers\ModuloEducativoController;
use App\Http\Controllers\LeccionEducativaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CompartidoController;
use App\Http\Controllers\PresupuestoDetalleCategoriaController;
use App\Http\Controllers\PerfilController;


// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PerfilController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [PerfilController::class, 'updatePassword'])->name('profile.password.update');

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
    Route::get('/compartido', [CompartidoController::class, 'index'])
        ->name('compartido.index');

    Route::post('/compartido/grupo', [CompartidoController::class, 'storeGrupo'])
        ->name('compartido.grupo.store');

    Route::put('/compartido/grupo/{id}', [CompartidoController::class, 'updateGrupo'])
        ->name('compartido.grupo.update');

    Route::post('/compartido/miembro', [CompartidoController::class, 'storeMiembro'])
        ->name('compartido.miembro.store');

    Route::put('/compartido/miembro/{id}', [CompartidoController::class, 'updateMiembro'])
        ->name('compartido.miembro.update');

    Route::post('/compartido/gasto', [CompartidoController::class, 'storeGasto'])
        ->name('compartido.gasto.store');

    Route::put('/compartido/gasto/{id}', [CompartidoController::class, 'updateGasto'])
        ->name('compartido.gasto.update');

    // Configuración 

    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::put('/configuracion/perfil', [ConfiguracionController::class, 'updatePerfil'])->name('configuracion.perfil.update');
    Route::put('/configuracion/moneda', [ConfiguracionController::class, 'updateMoneda'])->name('configuracion.moneda.update');
    Route::put('/configuracion/notificaciones', [ConfiguracionController::class, 'updateNotificaciones'])->name('configuracion.notificaciones.update');
    Route::put('/configuracion/seguridad', [ConfiguracionController::class, 'updateSeguridad'])->name('configuracion.seguridad.update');
    Route::put('/configuracion/password', [ConfiguracionController::class, 'updatePassword'])->name('configuracion.password.update');
    Route::get('/configuracion/exportar-datos', [ConfiguracionController::class, 'exportarDatos'])->name('configuracion.exportar');
    Route::delete('/configuracion/eliminar-cuenta', [ConfiguracionController::class, 'destroyCuenta'])->name('configuracion.destroy');
});

// Rutas de autenticación
require __DIR__ . '/autenticacion.php';
