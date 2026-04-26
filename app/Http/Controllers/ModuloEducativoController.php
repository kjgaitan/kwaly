<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuloEducativo\StoreModuloEducativoRequest;
use App\Http\Requests\ModuloEducativo\UpdateModuloEducativoRequest;
use App\Models\ModuloEducativo;

class ModuloEducativoController extends Controller
{
    public function index()
    {
        $modulos = ModuloEducativo::withCount('lecciones')
            ->orderBy('id_modulo', 'desc')
            ->get();

        return view('modulos-educativos.index', compact('modulos'));
    }

    public function create()
    {
        return view('modulos-educativos.create');
    }

    public function store(StoreModuloEducativoRequest $request)
    {
        ModuloEducativo::create($request->validated());

        return redirect()
            ->route('modulos-educativos.index')
            ->with('success', 'Modulo educativo registrado correctamente.');
    }

    public function edit(ModuloEducativo $modulo_educativo)
    {
        return view('modulos-educativos.edit', [
            'modulo' => $modulo_educativo,
        ]);
    }

    public function update(UpdateModuloEducativoRequest $request, ModuloEducativo $modulo_educativo)
    {
        $modulo_educativo->update($request->validated());

        return redirect()
            ->route('modulos-educativos.index')
            ->with('success', 'Modulo educativo actualizado correctamente.');
    }

    public function destroy(ModuloEducativo $modulo_educativo)
    {
        if ($modulo_educativo->lecciones()->exists()) {
            return redirect()
                ->route('modulos-educativos.index')
                ->with('error', 'No se puede eliminar el modulo porque tiene lecciones asociadas.');
        }

        $modulo_educativo->delete();

        return redirect()
            ->route('modulos-educativos.index')
            ->with('success', 'Modulo educativo eliminado correctamente.');
    }
}
