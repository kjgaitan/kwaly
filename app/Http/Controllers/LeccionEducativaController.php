<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeccionEducativa\StoreLeccionEducativaRequest;
use App\Http\Requests\LeccionEducativa\UpdateLeccionEducativaRequest;
use App\Models\LeccionEducativa;
use App\Models\ModuloEducativo;

class LeccionEducativaController extends Controller
{
    public function index(ModuloEducativo $modulo_educativo)
    {
        $lecciones = $modulo_educativo->lecciones()
            ->orderBy('id_leccion', 'desc')
            ->get();

        return view('lecciones-educativas.index', [
            'modulo' => $modulo_educativo,
            'lecciones' => $lecciones,
        ]);
    }

    public function create(ModuloEducativo $modulo_educativo)
    {
        return view('lecciones-educativas.create', [
            'modulo' => $modulo_educativo,
        ]);
    }

    public function store(StoreLeccionEducativaRequest $request, ModuloEducativo $modulo_educativo)
    {
        $modulo_educativo->lecciones()->create($request->validated());

        return redirect()
            ->route('modulos-educativos.lecciones.index', $modulo_educativo)
            ->with('success', 'Lección registrada correctamente.');
    }

    public function edit(ModuloEducativo $modulo_educativo, LeccionEducativa $leccion_educativa)
    {
        if ($leccion_educativa->id_modulo !== $modulo_educativo->id_modulo) {
            abort(404);
        }

        return view('lecciones-educativas.edit', [
            'modulo' => $modulo_educativo,
            'leccion' => $leccion_educativa,
        ]);
    }

    public function update(
        UpdateLeccionEducativaRequest $request,
        ModuloEducativo $modulo_educativo,
        LeccionEducativa $leccion_educativa
    ) {
        if ($leccion_educativa->id_modulo !== $modulo_educativo->id_modulo) {
            abort(404);
        }

        $leccion_educativa->update($request->validated());

        return redirect()
            ->route('modulos-educativos.lecciones.index', $modulo_educativo)
            ->with('success', 'Lección actualizada correctamente.');
    }

    public function destroy(ModuloEducativo $modulo_educativo, LeccionEducativa $leccion_educativa)
    {
        if ($leccion_educativa->id_modulo !== $modulo_educativo->id_modulo) {
            abort(404);
        }

        $leccion_educativa->delete();

        return redirect()
            ->route('modulos-educativos.lecciones.index', $modulo_educativo)
            ->with('success', 'Lección eliminada correctamente.');
    }
}