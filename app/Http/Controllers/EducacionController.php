<?php

namespace App\Http\Controllers;

use App\Models\ModuloEducativo;
use App\Models\ProgresoLeccion;
use Illuminate\Support\Facades\Auth;

class EducacionController extends Controller
{
    public function index()
    {
        $idUsuario = Auth::user()->id_usuario;

        $modulos = ModuloEducativo::with(['lecciones' => function ($query) {
            $query->orderBy('id_leccion');
        }])->get();

        $progreso = ProgresoLeccion::where('id_usuario', $idUsuario)
            ->where('completada', 1)
            ->pluck('id_leccion')
            ->toArray();

        $leccionIdsDisponibles = $modulos
            ->flatMap(fn($modulo) => $modulo->lecciones->pluck('id_leccion'))
            ->all();

        $totalLecciones = count($leccionIdsDisponibles);
        $leccionesCompletadas = count(array_intersect($progreso, $leccionIdsDisponibles));

        $porcentajeProgreso = $totalLecciones > 0
            ? round(($leccionesCompletadas / $totalLecciones) * 100)
            : 0;

        return view('educacion.index', compact(
            'modulos',
            'progreso',
            'totalLecciones',
            'leccionesCompletadas',
            'porcentajeProgreso'
        ));
    }

    public function completar($idLeccion)
    {
        $idUsuario = Auth::user()->id_usuario;

        ProgresoLeccion::updateOrCreate(
            [
                'id_usuario' => $idUsuario,
                'id_leccion' => $idLeccion,
            ],
            [
                'completada' => 1,
                'fecha_completada' => now(),
            ]
        );

        return back()->with('success', 'Lección completada correctamente.');
    }
}
