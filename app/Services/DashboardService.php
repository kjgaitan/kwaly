<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\MetaFinanciera;
use App\Models\PresupuestoMensual;
use App\Models\Transaccion;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Obtiene el resumen general del dashboard para un usuario.
     */
    public function obtenerResumen(int $idUsuario): array
    {
        Carbon::setLocale('es');

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

        $gastosPorCategoria = $this->obtenerGastosPorCategoria($idUsuario);
        $tendenciaMensual = $this->obtenerTendenciaMensual($idUsuario);
        $presupuesto = $this->obtenerResumenPresupuesto($idUsuario);
        $logros = $this->obtenerLogros($ingresosMes, $gastosMes, $facturasPendientes, $metasActivas, $presupuesto);

        return [
            'ingresosMes' => $ingresosMes,
            'gastosMes' => $gastosMes,
            'balance' => $balance,
            'ultimasTransacciones' => $ultimasTransacciones,
            'facturasPendientes' => $facturasPendientes,
            'metasActivas' => $metasActivas,
            'gastosPorCategoria' => $gastosPorCategoria,
            'tendenciaMensual' => $tendenciaMensual,
            'presupuestoDashboard' => $presupuesto,
            'logrosDashboard' => $logros,
        ];
    }

    private function obtenerGastosPorCategoria(int $idUsuario): array
    {
        $transacciones = Transaccion::with('categoria')
            ->where('id_usuario', $idUsuario)
            ->where('tipo_movimiento', 'gasto')
            ->whereMonth('fecha_transaccion', now()->month)
            ->whereYear('fecha_transaccion', now()->year)
            ->get();

        $total = (float) $transacciones->sum('monto');
        $colores = ['#8fffaf', '#63d66f', '#2e8f48', '#55c46a', '#4ef2ba', '#b8f7c7'];

        $categorias = $transacciones
            ->groupBy(fn ($transaccion) => optional($transaccion->categoria)->nombre ?? 'Sin categoria')
            ->map(fn ($items, $nombre) => [
                'nombre' => $nombre,
                'total' => (float) $items->sum('monto'),
            ])
            ->sortByDesc('total')
            ->values()
            ->take(6)
            ->map(function ($categoria, $indice) use ($total, $colores) {
                $categoria['porcentaje'] = $total > 0 ? ($categoria['total'] / $total) * 100 : 0;
                $categoria['color'] = $colores[$indice] ?? '#72f59a';

                return $categoria;
            })
            ->all();

        return [
            'total' => $total,
            'categorias' => $categorias,
            'gradiente' => $this->crearGradienteCircular($categorias),
        ];
    }

    private function obtenerTendenciaMensual(int $idUsuario): array
    {
        $meses = collect(range(5, 0))
            ->map(function ($resta) {
                $fecha = now()->copy()->startOfMonth()->subMonths($resta);

                return [
                    'anio' => $fecha->year,
                    'mes' => $fecha->month,
                    'etiqueta' => ucfirst($fecha->translatedFormat('M')),
                    'balance' => 0.0,
                ];
            });

        $desde = now()->copy()->startOfMonth()->subMonths(5);
        $transacciones = Transaccion::where('id_usuario', $idUsuario)
            ->where('fecha_transaccion', '>=', $desde)
            ->get(['tipo_movimiento', 'monto', 'fecha_transaccion']);

        $meses = $meses->map(function ($mes) use ($transacciones) {
            $movimientosMes = $transacciones->filter(function ($transaccion) use ($mes) {
                $fecha = Carbon::parse($transaccion->fecha_transaccion);

                return $fecha->year === $mes['anio'] && $fecha->month === $mes['mes'];
            });

            $ingresos = (float) $movimientosMes->where('tipo_movimiento', 'ingreso')->sum('monto');
            $gastos = (float) $movimientosMes->where('tipo_movimiento', 'gasto')->sum('monto');
            $mes['balance'] = $ingresos - $gastos;

            return $mes;
        })->values();

        $balanceActual = (float) ($meses->last()['balance'] ?? 0);
        $balanceAnterior = (float) ($meses->slice(-2, 1)->first()['balance'] ?? 0);
        $variacion = $balanceAnterior != 0
            ? (($balanceActual - $balanceAnterior) / abs($balanceAnterior)) * 100
            : ($balanceActual > 0 ? 100 : 0);

        return [
            'meses' => $meses->all(),
            'balanceActual' => $balanceActual,
            'variacion' => $variacion,
            'path' => $this->crearPathTendencia($meses->pluck('balance')->all()),
        ];
    }

    private function obtenerResumenPresupuesto(int $idUsuario): array
    {
        $presupuesto = PresupuestoMensual::with(['detalles.categoria'])
            ->where('id_usuario', $idUsuario)
            ->where('anio', now()->year)
            ->where('mes', now()->month)
            ->first();

        if (!$presupuesto) {
            return [
                'existe' => false,
                'items' => [],
            ];
        }

        $detalles = $presupuesto->detalles;
        $items = collect([
            'necesidades' => 'Necesidades',
            'deseos' => 'Deseos',
            'ahorro' => 'Ahorros',
        ])->map(function ($etiqueta, $tipo) use ($presupuesto, $detalles, $idUsuario) {
            $porcentaje = (float) $presupuesto->{'porcentaje_' . $tipo};
            $limite = ((float) $presupuesto->ingreso_estimado * $porcentaje) / 100;
            $categoriaIds = $detalles->where('tipo_presupuesto', $tipo)->pluck('id_categoria')->filter();
            $gastado = $categoriaIds->isEmpty()
                ? 0
                : (float) Transaccion::where('id_usuario', $idUsuario)
                    ->where('tipo_movimiento', 'gasto')
                    ->whereIn('id_categoria', $categoriaIds)
                    ->whereYear('fecha_transaccion', $presupuesto->anio)
                    ->whereMonth('fecha_transaccion', $presupuesto->mes)
                    ->sum('monto');

            return [
                'tipo' => $tipo,
                'etiqueta' => $etiqueta,
                'porcentaje' => $porcentaje,
                'limite' => $limite,
                'gastado' => $gastado,
                'uso' => $limite > 0 ? min(($gastado / $limite) * 100, 100) : 0,
            ];
        })->values()->all();

        return [
            'existe' => true,
            'presupuesto' => $presupuesto,
            'items' => $items,
        ];
    }

    private function obtenerLogros(float $ingresosMes, float $gastosMes, int $facturasPendientes, int $metasActivas, array $presupuesto): array
    {
        $ahorro = $ingresosMes - $gastosMes;
        $porcentajeAhorro = $ingresosMes > 0 ? ($ahorro / $ingresosMes) * 100 : 0;
        $logros = [];

        if ($porcentajeAhorro >= 20) {
            $logros[] = [
                'icono' => 'bi-piggy-bank',
                'titulo' => 'Ahorro mensual',
                'descripcion' => 'Ahorraste al menos el 20% de tus ingresos este mes.',
                'activo' => true,
            ];
        }

        if ($facturasPendientes === 0) {
            $logros[] = [
                'icono' => 'bi-check-circle',
                'titulo' => 'Pagos al dia',
                'descripcion' => 'No tienes facturas pendientes registradas.',
                'activo' => true,
            ];
        }

        if ($metasActivas > 0) {
            $logros[] = [
                'icono' => 'bi-bullseye',
                'titulo' => 'Metas en marcha',
                'descripcion' => 'Tienes ' . $metasActivas . ' meta(s) financiera(s) activa(s).',
                'activo' => true,
            ];
        }

        if (($presupuesto['existe'] ?? false) && collect($presupuesto['items'])->every(fn ($item) => $item['uso'] <= 100)) {
            $logros[] = [
                'icono' => 'bi-clipboard-check',
                'titulo' => 'Presupuesto controlado',
                'descripcion' => 'Tus categorias presupuestarias siguen dentro del limite.',
                'activo' => true,
            ];
        }

        return array_slice($logros, 0, 3);
    }

    private function crearGradienteCircular(array $categorias): string
    {
        if (empty($categorias)) {
            return 'conic-gradient(#26352d 0% 100%)';
        }

        $inicio = 0;
        $partes = [];

        foreach ($categorias as $categoria) {
            $fin = $inicio + $categoria['porcentaje'];
            $partes[] = sprintf('%s %.2f%% %.2f%%', $categoria['color'], $inicio, $fin);
            $inicio = $fin;
        }

        return 'conic-gradient(' . implode(',', $partes) . ')';
    }

    private function crearPathTendencia(array $valores): array
    {
        if (empty($valores)) {
            return [
                'linea' => 'M0,150 L600,150',
                'relleno' => 'M0,150 L600,150 L600,300 L0,300 Z',
            ];
        }

        $min = min($valores);
        $max = max($valores);
        $rango = max($max - $min, 1);
        $ultimoIndice = max(count($valores) - 1, 1);
        $puntos = [];

        foreach ($valores as $indice => $valor) {
            $x = ($indice / $ultimoIndice) * 600;
            $y = 250 - ((($valor - $min) / $rango) * 190);
            $puntos[] = [round($x, 2), round($y, 2)];
        }

        $linea = collect($puntos)
            ->map(fn ($punto, $indice) => ($indice === 0 ? 'M' : 'L') . $punto[0] . ',' . $punto[1])
            ->implode(' ');

        return [
            'linea' => $linea,
            'relleno' => $linea . ' L600,300 L0,300 Z',
        ];
    }
}
