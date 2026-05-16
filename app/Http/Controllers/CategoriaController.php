<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Categoria\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index()
    {
        return redirect()->route('configuracion.index');
    }

    public function create()
    {
        return redirect()->route('configuracion.index');
    }

    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre' => $request->nombre,
            'icono' => $request->icono,
            'color_hex' => $request->color_hex,
        ]);

        return redirect()
            ->route('configuracion.index')
            ->with('success', MensajeHelper::creado('Categoría'));
    }

    public function show(string $id)
    {
        return redirect()->route('configuracion.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('configuracion.index');
    }

    public function update(UpdateCategoriaRequest $request, string $id)
    {
        $categoria = Categoria::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $categoria->update($request->only([
            'nombre',
            'icono',
            'color_hex',
        ]));

        return redirect()
            ->route('configuracion.index')
            ->with('success', MensajeHelper::actualizado('Categoría'));
    }

    public function destroy(string $id)
    {
        $categoria = Categoria::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $categoria->delete();

        return redirect()
            ->route('configuracion.index')
            ->with('success', MensajeHelper::eliminado('Categoría'));
    }
}