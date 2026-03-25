<?php

namespace App\Services;

use App\Helpers\CalendarioHelper;
use App\Models\Factura;
use App\Models\Transaccion;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalendarioService
{
    public function obtenerDatosVista(int $idUsuario, ?string $mes = null): array
    {
        Carbon::setLocale('es');

        $fecha = $mes
            ? Carbon::createFromFormat('Y-m', $mes)->startOfMonth()
            : now()->startOfMonth();

        $inicioCalendario = $fecha->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $finCalendario = $fecha->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $dias = collect();
        $cursor = $inicioCalendario->copy();

        while ($cursor->lte($finCalendario)) {
            $dias->push($cursor->copy());
            $cursor->addDay();
        }

        $transacciones = $this->obtenerTransaccionesDelMes($idUsuario, $fecha);
        $facturas = $this->obtenerFacturasDelMes($idUsuario, $fecha);

        $eventosPorDia = $this->agruparEventosPorDia($transacciones, $facturas);

        $ingresosPrevistos = $transacciones
            ->where('tipo', 'ingreso')
            ->sum('monto');

        $gastosPrevistos = $transacciones
            ->where('tipo', 'gasto')
            ->sum('monto') + $facturas->sum('monto_total');

        $balancePrevisto = $ingresosPrevistos - $gastosPrevistos;

        return [
            'fecha' => $fecha,
            'dias' => $dias,
            'eventosPorDia' => $eventosPorDia,
            'ingresosPrevistos' => $ingresosPrevistos,
            'gastosPrevistos' => $gastosPrevistos,
            'balancePrevisto' => $balancePrevisto,
            'consejo' => CalendarioHelper::obtenerConsejoFinanciero($balancePrevisto),
        ];
    }

    protected function obtenerTransaccionesDelMes(int $idUsuario, Carbon $fecha): Collection
    {
        return Transaccion::query()
            ->where('id_usuario', $idUsuario)
            ->whereBetween('fecha_transaccion', [
                $fecha->copy()->startOfMonth()->toDateString(),
                $fecha->copy()->endOfMonth()->toDateString(),
            ])
            ->orderBy('fecha_transaccion')
            ->get();
    }

    protected function obtenerFacturasDelMes(int $idUsuario, Carbon $fecha): Collection
    {
        if (!class_exists(Factura::class)) {
            return collect();
        }

        return Factura::query()
            ->where('id_usuario', $idUsuario)
            ->whereBetween('fecha_vencimiento', [
                $fecha->copy()->startOfMonth()->toDateString(),
                $fecha->copy()->endOfMonth()->toDateString(),
            ])
            ->orderBy('fecha_vencimiento')
            ->get();
    }

    protected function agruparEventosPorDia(Collection $transacciones, Collection $facturas): array
    {
        $eventosPorDia = [];

        foreach ($transacciones as $transaccion) {
            $clave = Carbon::parse($transaccion->fecha_transaccion)->format('Y-m-d');

            $eventosPorDia[$clave][] = [
                'titulo' => $transaccion->titulo ?? 'Transacción',
                'tipo' => $transaccion->tipo ?? 'recordatorio',
            ];
        }

        foreach ($facturas as $factura) {
            $clave = Carbon::parse($factura->fecha_vencimiento)->format('Y-m-d');

            $eventosPorDia[$clave][] = [
                'titulo' => $factura->titulo ?? $factura->concepto ?? 'Factura',
                'tipo' => 'recordatorio',
            ];
        }

        return $eventosPorDia;
    }
}