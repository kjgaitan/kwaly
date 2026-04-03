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

        $modulos = ModuloEducativo::with('lecciones')->get();

        $progreso = ProgresoLeccion::where('id_usuario', $idUsuario)
            ->where('completada', 1)
            ->pluck('id_leccion')
            ->toArray();

        $totalLecciones = $modulos->sum(fn($modulo) => $modulo->lecciones->count());
        $leccionesCompletadas = count($progreso);

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

        return redirect()->route('educacion.index')->with('success', 'Lección completada correctamente.');
    }
}