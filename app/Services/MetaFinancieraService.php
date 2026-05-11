<?php

namespace App\Services;

use App\Models\MetaFinanciera;
use Carbon\Carbon;

class MetaFinancieraService
{
    public function obtenerDatosVista(int $idUsuario): array
    {
        $metas = MetaFinanciera::with('aportaciones')
            ->where('id_usuario', $idUsuario)
            ->get();

        $metasProcesadas = $metas->map(function ($meta) {
            $aportacionesSum = $meta->aportaciones->sum('monto');
            $montoActual = ($meta->monto_actual ?? 0) + $aportacionesSum;

            $progreso = $meta->monto_objetivo > 0
                ? ($montoActual / $meta->monto_objetivo) * 100
                : 0;

            $progreso = min($progreso, 100);
            $faltante = max($meta->monto_objetivo - $montoActual, 0);

            $diasRestantes = null;
            if ($meta->fecha_limite) {
                $diasRestantes = Carbon::now()
                    ->diffInDays($meta->fecha_limite, false);
            }

            $completada = $meta->estado === 'completada' || $progreso >= 100;

            return [
                'id_meta' => $meta->id_meta,
                'titulo' => $meta->titulo,
                'descripcion' => $meta->descripcion,
                'monto_objetivo' => $meta->monto_objetivo,
                'monto_actual' => $montoActual,
                'faltante' => $faltante,
                'progreso' => round($progreso, 2),
                'estado' => $meta->estado,
                'prioridad' => $meta->prioridad,
                'fecha_inicio' => isset($meta->fecha_inicio) ? Carbon::parse($meta->fecha_inicio)->format('d/m/Y') : null,
                'fecha_limite' => isset($meta->fecha_limite) ? Carbon::parse($meta->fecha_limite)->format('d/m/Y') : null,
                'dias_restantes' => $diasRestantes,
                'completada' => $completada,
            ];
        });

        $logros = $this->obtenerLogros($metasProcesadas);

        return [
            'metas' => $metasProcesadas,
            'metasActivas' => $metasProcesadas->where('estado', 'activa'),
            'metasPausadas' => $metasProcesadas->where('estado', 'pausada'),
            'metasCompletadas' => $metasProcesadas->where('completada', true),
            'resumen' => [
                'metas_completadas' => $metasProcesadas->where('completada', true)->count(),
                'metas_activas' => $metasProcesadas->where('estado', 'activa')->count(),
                'metas_pausadas' => $metasProcesadas->where('estado', 'pausada')->count(),
                'logros_desbloqueados' => collect($logros)->where('desbloqueado', true)->count(),
                'total_logros' => count($logros),
            ],
            'logros' => $logros,
        ];
    }

    private function obtenerLogros($metas): array
    {
        $cantidadMetas = $metas->count();
        $cantidadCompletadas = $metas->where('completada', true)->count();

        $tieneMetaGrandeCompletada = $metas->contains(function ($meta) {
            return ($meta['completada'] ?? false) && ($meta['monto_objetivo'] ?? 0) >= 1000;
        });

        return [
            [
                'titulo' => 'Primera Meta',
                'descripcion' => 'Completaste tu primera meta financiera.',
                'icono' => 'bi bi-bullseye',
                'desbloqueado' => $cantidadCompletadas >= 1,
            ],
            [
                'titulo' => 'Ahorrador Constante',
                'descripcion' => 'Has creado al menos 3 metas financieras.',
                'icono' => 'bi bi-graph-up-arrow',
                'desbloqueado' => $cantidadMetas >= 3,
            ],
            [
                'titulo' => 'Meta Grande',
                'descripcion' => 'Completaste una meta de más de 1000€.',
                'icono' => 'bi bi-trophy',
                'desbloqueado' => $tieneMetaGrandeCompletada,
            ],
            [
                'titulo' => 'Disciplina Total',
                'descripcion' => 'Has completado 5 metas financieras.',
                'icono' => 'bi bi-star',
                'desbloqueado' => $cantidadCompletadas >= 5,
            ],
        ];
    }
}