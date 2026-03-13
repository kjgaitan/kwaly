<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\MetaFinanciera;
use App\Models\Transaccion;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de mostrar el panel principal de la aplicación.
 * 
 * Este controlador reúne la información más relevante del usuario
 * para mostrarla en el dashboard.
 */
class DashboardController extends Controller
{
    /**
     * Muestra el resumen general del usuario autenticado.
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Calcular los ingresos del mes actual
        $ingresosMes = Transaccion::where('id_usuario', $usuario->id_usuario)
            ->where('tipo_movimiento', 'ingreso')
            ->whereMonth('fecha_transaccion', now()->month)
            ->whereYear('fecha_transaccion', now()->year)
            ->sum('monto');

        // Calcular los gastos del mes actual
        $gastosMes = Transaccion::where('id_usuario', $usuario->id_usuario)
            ->where('tipo_movimiento', 'gasto')
            ->whereMonth('fecha_transaccion', now()->month)
            ->whereYear('fecha_transaccion', now()->year)
            ->sum('monto');

        // Calcular el balance mensual (ingresos - gastos)
        $balance = $ingresosMes - $gastosMes;

        // Obtener las últimas 5 transacciones registradas
        $ultimasTransacciones = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', $usuario->id_usuario)
            ->orderByDesc('fecha_transaccion')
            ->take(5)
            ->get();

        // Contar facturas pendientes del usuario
        $facturasPendientes = Factura::where('id_usuario', $usuario->id_usuario)
            ->where('estado', 'pendiente')
            ->count();

        // Contar metas financieras activas
        $metasActivas = MetaFinanciera::where('id_usuario', $usuario->id_usuario)
            ->where('estado', 'activa')
            ->count();

        // Enviar los datos al dashboard
        return view('dashboard.index', compact(
            'ingresosMes',
            'gastosMes',
            'balance',
            'ultimasTransacciones',
            'facturasPendientes',
            'metasActivas'
        ));
    }
}