<?php

namespace App\Services;

use App\Models\Transaccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteService
{
    public function obtenerDatosReportes(int $idUsuario, int $anio, int $mes): array
    {
        Carbon::setLocale('es');

        $mesesNombres = [
            'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
        ];

        $mesesSelect = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $aniosDisponibles = $this->obtenerAniosDisponibles($idUsuario);

        if (empty($aniosDisponibles)) {
            $aniosDisponibles = [now()->year];
        }

        $resumenMensual = $this->obtenerResumenMensual($idUsuario, $anio);
        $gastosPorCategoria = $this->obtenerGastosPorCategoria($idUsuario, $anio, $mes);

        $ingresosMensuales = [];
        $gastosMensuales = [];

        for ($numeroMes = 1; $numeroMes <= 12; $numeroMes++) {
            $ingresosMensuales[] = (float) ($resumenMensual[$numeroMes]['ingresos'] ?? 0);
            $gastosMensuales[] = (float) ($resumenMensual[$numeroMes]['gastos'] ?? 0);
        }

        $maxIngreso = !empty($ingresosMensuales) ? max($ingresosMensuales) : 0;
        $maxGasto = !empty($gastosMensuales) ? max($gastosMensuales) : 0;

        $indiceIngresoMasAlto = array_search($maxIngreso, $ingresosMensuales, true);
        $indiceGastoMasAlto = array_search($maxGasto, $gastosMensuales, true);

        $mesIngresoMasAlto = $indiceIngresoMasAlto !== false
            ? ($mesesSelect[$indiceIngresoMasAlto + 1] ?? '-')
            : '-';

        $mesGastoMasAlto = $indiceGastoMasAlto !== false
            ? ($mesesSelect[$indiceGastoMasAlto + 1] ?? '-')
            : '-';

        $promedioIngresos = count($ingresosMensuales) > 0
            ? array_sum($ingresosMensuales) / count($ingresosMensuales)
            : 0;

        $promedioGastos = count($gastosMensuales) > 0
            ? array_sum($gastosMensuales) / count($gastosMensuales)
            : 0;

        return [
            'anio' => $anio,
            'mes' => $mes,
            'aniosDisponibles' => $aniosDisponibles,
            'mesesSelect' => $mesesSelect,
            'mesesNombres' => $mesesNombres,
            'ingresosMensuales' => $ingresosMensuales,
            'gastosMensuales' => $gastosMensuales,
            'categoriasLabels' => $gastosPorCategoria['labels'],
            'categoriasTotales' => $gastosPorCategoria['totales'],
            'maxIngreso' => $maxIngreso,
            'maxGasto' => $maxGasto,
            'promedioIngresos' => $promedioIngresos,
            'promedioGastos' => $promedioGastos,
            'mesIngresoMasAlto' => $mesIngresoMasAlto,
            'mesGastoMasAlto' => $mesGastoMasAlto,
        ];
    }

    protected function obtenerAniosDisponibles(int $idUsuario): array
    {
        return Transaccion::query()
            ->where('id_usuario', $idUsuario)
            ->whereNotNull('fecha_transaccion')
            ->selectRaw('YEAR(fecha_transaccion) as anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio')
            ->map(fn ($anio) => (int) $anio)
            ->filter(fn ($anio) => $anio >= 2000 && $anio <= 2100)
            ->values()
            ->toArray();
    }

    protected function obtenerResumenMensual(int $idUsuario, int $anio): array
    {
        $registros = Transaccion::query()
            ->where('id_usuario', $idUsuario)
            ->whereYear('fecha_transaccion', $anio)
            ->selectRaw('MONTH(fecha_transaccion) as mes')
            ->selectRaw("
                SUM(
                    CASE
                        WHEN LOWER(tipo_movimiento) = 'ingreso' THEN monto
                        ELSE 0
                    END
                ) as total_ingresos
            ")
            ->selectRaw("
                SUM(
                    CASE
                        WHEN LOWER(tipo_movimiento) = 'gasto' THEN monto
                        ELSE 0
                    END
                ) as total_gastos
            ")
            ->groupBy(DB::raw('MONTH(fecha_transaccion)'))
            ->orderBy(DB::raw('MONTH(fecha_transaccion)'))
            ->get();

        $resultado = [];

        foreach ($registros as $registro) {
            $resultado[(int) $registro->mes] = [
                'ingresos' => (float) $registro->total_ingresos,
                'gastos' => (float) $registro->total_gastos,
            ];
        }

        return $resultado;
    }

    protected function obtenerGastosPorCategoria(int $idUsuario, int $anio, int $mes): array
    {
        $registros = Transaccion::query()
            ->leftJoin('categorias', 'transacciones.id_categoria', '=', 'categorias.id_categoria')
            ->where('transacciones.id_usuario', $idUsuario)
            ->whereYear('transacciones.fecha_transaccion', $anio)
            ->whereMonth('transacciones.fecha_transaccion', $mes)
            ->whereRaw("LOWER(transacciones.tipo_movimiento) = 'gasto'")
            ->selectRaw("COALESCE(categorias.nombre, 'Sin categoría') as categoria_nombre")
            ->selectRaw('SUM(transacciones.monto) as total')
            ->groupBy('categoria_nombre')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $registros->pluck('categoria_nombre')->toArray(),
            'totales' => $registros->pluck('total')->map(fn ($valor) => (float) $valor)->toArray(),
        ];
    }
}