<?php

namespace App\Services;

use App\Models\PresupuestoDetalleCategoria;
use App\Models\Transaccion;

class TransaccionService
{
    public function obtenerDatosIndex(int $idUsuario, ?string $busqueda, ?string $tipo): array
    {
        $query = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', $idUsuario);

        if (!empty($busqueda)) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', '%' . $busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $busqueda . '%')
                    ->orWhereHas('categoria', function ($sub) use ($busqueda) {
                        $sub->where('nombre', 'like', '%' . $busqueda . '%');
                    });
            });
        }

        if (!empty($tipo) && in_array($tipo, ['ingreso', 'gasto'])) {
            $query->where('tipo_movimiento', $tipo);
        }

        $transacciones = $query->orderByDesc('fecha_transaccion')->get();

        $totalIngresos = (clone $query)->where('tipo_movimiento', 'ingreso')->sum('monto');
        $totalGastos = (clone $query)->where('tipo_movimiento', 'gasto')->sum('monto');
        $totalTransacciones = (clone $query)->count();

        return [
            'transacciones' => $transacciones,
            'totalIngresos' => $totalIngresos,
            'totalGastos' => $totalGastos,
            'totalTransacciones' => $totalTransacciones,
        ];
    }

    public function recalcularSobresRelacionados(Transaccion $transaccion): void
    {
        if (
            $transaccion->tipo_movimiento !== 'gasto' ||
            empty($transaccion->id_categoria) ||
            empty($transaccion->fecha_transaccion)
        ) {
            return;
        }

        $anio = date('Y', strtotime($transaccion->fecha_transaccion));
        $mes = date('n', strtotime($transaccion->fecha_transaccion));

        $detalles = PresupuestoDetalleCategoria::where('id_categoria', $transaccion->id_categoria)
            ->whereHas('presupuesto', function ($query) use ($transaccion, $anio, $mes) {
                $query->where('id_usuario', $transaccion->id_usuario)
                    ->where('anio', $anio)
                    ->where('mes', $mes);
            })
            ->get();

        foreach ($detalles as $detalle) {
            $detalle->recalcularMontoGastado();
        }
    }

    public function recalcularSobresPorDatosAnteriores(int $usuarioId, $categoriaId, $fecha): void
    {
        if (empty($categoriaId) || empty($fecha)) {
            return;
        }

        $anio = date('Y', strtotime($fecha));
        $mes = date('n', strtotime($fecha));

        $detalles = PresupuestoDetalleCategoria::where('id_categoria', $categoriaId)
            ->whereHas('presupuesto', function ($query) use ($usuarioId, $anio, $mes) {
                $query->where('id_usuario', $usuarioId)
                    ->where('anio', $anio)
                    ->where('mes', $mes);
            })
            ->get();

        foreach ($detalles as $detalle) {
            $detalle->recalcularMontoGastado();
        }
    }
}