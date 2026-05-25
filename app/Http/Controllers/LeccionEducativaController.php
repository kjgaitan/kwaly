<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeccionEducativa\StoreLeccionEducativaRequest;
use App\Http\Requests\LeccionEducativa\UpdateLeccionEducativaRequest;
use App\Models\LeccionEducativa;
use App\Models\ModuloEducativo;
use App\Models\ProgresoLeccion;

class LeccionEducativaController extends Controller
{
    public function index(ModuloEducativo $modulo)
    {
        $lecciones = $modulo->lecciones()
            ->orderBy('id_leccion', 'desc')
            ->get();

        return view('lecciones-educativas.index', [
            'modulo' => $modulo,
            'lecciones' => $lecciones,
            'esAdmin' => auth()->user()->isAdmin(),
        ]);
    }

    public function create(ModuloEducativo $modulo)
    {
        $this->authorizeAdmin();

        return view('lecciones-educativas.create', [
            'modulo' => $modulo,
        ]);
    }

    public function store(StoreLeccionEducativaRequest $request, ModuloEducativo $modulo)
    {
        $this->authorizeAdmin();

        $modulo->lecciones()->create($request->validated());

        return redirect()
            ->route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo])
            ->with('success', 'Leccion registrada correctamente.');
    }

    public function edit(ModuloEducativo $modulo, LeccionEducativa $leccion)
    {
        $this->authorizeAdmin();
        $this->ensureLessonBelongsToModule($modulo, $leccion);

        return view('lecciones-educativas.edit', [
            'modulo' => $modulo,
            'leccion' => $leccion,
        ]);
    }

    public function show(ModuloEducativo $modulo, LeccionEducativa $leccion)
    {
        $this->ensureLessonBelongsToModule($modulo, $leccion);

        $idUsuario = auth()->user()->id_usuario;
        $completada = ProgresoLeccion::where('id_usuario', $idUsuario)
            ->where('id_leccion', $leccion->id_leccion)
            ->where('completada', 1)
            ->exists();

        $leccionesModulo = $modulo->lecciones()
            ->orderBy('id_leccion')
            ->get();

        $leccionIds = $leccionesModulo->pluck('id_leccion')->values();
        $posicionActual = $leccionIds->search($leccion->id_leccion);

        $leccionAnterior = $posicionActual !== false && $posicionActual > 0
            ? $leccionesModulo[$posicionActual - 1]
            : null;

        $leccionSiguiente = $posicionActual !== false && $posicionActual < $leccionesModulo->count() - 1
            ? $leccionesModulo[$posicionActual + 1]
            : null;

        $leccionesCompletadasModulo = ProgresoLeccion::where('id_usuario', $idUsuario)
            ->whereIn('id_leccion', $leccionIds)
            ->where('completada', 1)
            ->count();

        $totalLeccionesModulo = $leccionesModulo->count();
        $porcentajeModulo = $totalLeccionesModulo > 0
            ? round(($leccionesCompletadasModulo / $totalLeccionesModulo) * 100)
            : 0;

        return view('lecciones-educativas.show', [
            'modulo' => $modulo,
            'leccion' => $leccion,
            'completada' => $completada,
            'esAdmin' => auth()->user()->isAdmin(),
            'leccionAnterior' => $leccionAnterior,
            'leccionSiguiente' => $leccionSiguiente,
            'posicionActual' => $posicionActual === false ? 1 : $posicionActual + 1,
            'totalLeccionesModulo' => $totalLeccionesModulo,
            'leccionesCompletadasModulo' => $leccionesCompletadasModulo,
            'porcentajeModulo' => $porcentajeModulo,
        ]);
    }

    public function update(
        UpdateLeccionEducativaRequest $request,
        ModuloEducativo $modulo,
        LeccionEducativa $leccion
    ) {
        $this->authorizeAdmin();
        $this->ensureLessonBelongsToModule($modulo, $leccion);

        $leccion->update($request->validated());

        return redirect()
            ->route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo])
            ->with('success', 'Leccion actualizada correctamente.');
    }

    public function destroy(ModuloEducativo $modulo, LeccionEducativa $leccion)
    {
        $this->authorizeAdmin();
        $this->ensureLessonBelongsToModule($modulo, $leccion);

        ProgresoLeccion::where('id_leccion', $leccion->id_leccion)->delete();
        $leccion->delete();

        return redirect()
            ->route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo])
            ->with('success', 'Leccion eliminada correctamente.');
    }

    private function ensureLessonBelongsToModule(ModuloEducativo $modulo, LeccionEducativa $leccion): void
    {
        if ((int) $leccion->id_modulo !== (int) $modulo->id_modulo) {
            abort(404);
        }
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
