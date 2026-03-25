<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\MetaFinanciera;
use App\Models\Transaccion;

class DashboardService
{
    /**
     * Obtiene el resumen general del dashboard para un usuario.
     */
    public function obtenerResumen(int $idUsuario): array
    {
        $ingresosMes = Transaccion::where('id_usuario', $idUsuario)
            ->where('tipo_movimiento', 'ingreso')
            ->whereMonth('fecha_transaccion', now()->month)
            ->whereYear('fecha_transaccion', now()->year)
            ->sum('monto');

        $gastosMes = Transaccion::where('id_usuario', $idUsuario)
            ->where('tipo_movimiento', 'gasto')
            ->whereMonth('fecha_transaccion', now()->month)
            ->whereYear('fecha_transaccion', now()->year)
            ->sum('monto');

        $balance = $ingresosMes - $gastosMes;

        $ultimasTransacciones = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', $idUsuario)
            ->orderByDesc('fecha_transaccion')
            ->take(5)
            ->get();

        $facturasPendientes = Factura::where('id_usuario', $idUsuario)
            ->where('estado', 'pendiente')
            ->count();

        $metasActivas = MetaFinanciera::where('id_usuario', $idUsuario)
            ->where('estado', 'activa')
            ->count();

        return [
            'ingresosMes' => $ingresosMes,
            'gastosMes' => $gastosMes,
            'balance' => $balance,
            'ultimasTransacciones' => $ultimasTransacciones,
            'facturasPendientes' => $facturasPendientes,
            'metasActivas' => $metasActivas,
        ];
    }
}