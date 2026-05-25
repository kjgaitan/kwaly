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
        $this->authorizeAdmin();

        return view('modulos-educativos.create');
    }

    public function store(StoreModuloEducativoRequest $request)
    {
        $this->authorizeAdmin();

        ModuloEducativo::create($request->validated() + [
            'duracion_minutos' => 0,
        ]);

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Modulo educativo registrado correctamente.');
    }

    public function edit(ModuloEducativo $modulo)
    {
        $this->authorizeAdmin();

        return view('modulos-educativos.edit', [
            'modulo' => $modulo,
        ]);
    }

    public function update(UpdateModuloEducativoRequest $request, ModuloEducativo $modulo)
    {
        $this->authorizeAdmin();

        $leccionIds = $modulo->lecciones()->pluck('id_leccion');

        $modulo->update($request->validated() + [
            'duracion_minutos' => 0,
        ]);

        if ($leccionIds->isNotEmpty()) {
            ProgresoLeccion::whereIn('id_leccion', $leccionIds)->delete();
            $modulo->lecciones()->delete();
        }

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Modulo educativo actualizado correctamente. Sus lecciones anteriores se vaciaron para crear contenido nuevo.');
    }

    public function destroy(ModuloEducativo $modulo)
    {
        $this->authorizeAdmin();

        $leccionIds = $modulo->lecciones()->pluck('id_leccion');

        ProgresoLeccion::whereIn('id_leccion', $leccionIds)->delete();
        $modulo->lecciones()->delete();
        $modulo->delete();

        return redirect()
            ->route('educacion.index')
            ->with('success', 'Modulo educativo eliminado correctamente.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
