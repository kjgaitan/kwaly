<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuloEducativo\StoreModuloEducativoRequest;
use App\Http\Requests\ModuloEducativo\UpdateModuloEducativoRequest;
use App\Models\ModuloEducativo;
use App\Models\ProgresoLeccion;

class ModuloEducativoController extends Controller
{
    public function index()
    {
        return redirect()->route('educacion.index');
    }

    public function create()
    {
        return view('modulos-educativos.create');
    }

    public function store(StoreModuloEducativoRequest $request)
    {
        ModuloEducativo::create($request->validated() + [
            'duracion_minutos' => 0,
        ]);

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Módulo educativo registrado correctamente.');
    }

    public function edit(ModuloEducativo $modulo)
    {
        return view('modulos-educativos.edit', [
            'modulo' => $modulo,
        ]);
    }

    public function update(UpdateModuloEducativoRequest $request, ModuloEducativo $modulo)
    {
        $modulo->update($request->validated() + [
            'duracion_minutos' => 0,
        ]);

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Módulo educativo actualizado correctamente.');
    }

    public function destroy(ModuloEducativo $modulo)
    {
        $leccionIds = $modulo->lecciones()->pluck('id_leccion');

        ProgresoLeccion::whereIn('id_leccion', $leccionIds)->delete();
        $modulo->lecciones()->delete();
        $modulo->delete();

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Módulo educativo eliminado correctamente.');
    }
}
