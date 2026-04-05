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

            $montoActual = $meta->aportaciones->sum('monto');

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

            return [
                'id_meta' => $meta->id_meta,
                'titulo' => $meta->titulo,
                'descripcion' => $meta->descripcion,
                'objetivo' => $meta->monto_objetivo,
                'ahorrado' => $montoActual,
                'faltante' => $faltante,
                'progreso' => round($progreso, 2),
                'estado' => $meta->estado,
                'prioridad' => $meta->prioridad,
                'dias_restantes' => $diasRestantes,
                'completada' => $progreso >= 100,
            ];
        });

        return [
            'metas' => $metasProcesadas,
            'metasActivas' => $metasProcesadas->where('estado', 'activa'),
            'metasCompletadas' => $metasProcesadas->where('completada', true),
            'resumen' => [
                'completadas' => $metasProcesadas->where('completada', true)->count(),
                'activas' => $metasProcesadas->where('estado', 'activa')->count(),
                'total' => $metasProcesadas->count(),
            ]
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