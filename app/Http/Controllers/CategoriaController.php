<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las categorías del usuario.
 * 
 * Permite listar, crear, visualizar, editar y eliminar categorías
 * asociadas al usuario autenticado.
 */
class CategoriaController extends Controller
{
    /**
     * Muestra el listado de categorías disponibles para el usuario.
     * Incluye tanto categorías globales como las creadas por el usuario.
     */
    public function index()
    {
        $categorias = Categoria::where(function ($query) {
                $query->whereNull('id_usuario')
                      ->orWhere('id_usuario', Auth::user()->id_usuario);
            })
            ->orderBy('nombre')
            ->get();

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_categoria' => 'required|in:ingreso,gasto',
            'icono' => 'nullable|string|max:100',
            'color_hex' => 'nullable|string|max:7',
        ]);

        // Creación de la categoría asociada al usuario autenticado
        Categoria::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre' => $request->nombre,
            'tipo_categoria' => $request->tipo_categoria,
            'icono' => $request->icono,
            'color_hex' => $request->color_hex,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Muestra el detalle de una categoría específica.
     */
    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza los datos de una categoría en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_categoria' => 'required|in:ingreso,gasto',
            'icono' => 'nullable|string|max:100',
            'color_hex' => 'nullable|string|max:7',
        ]);

        // Actualización de los campos de la categoría
        $categoria->update($request->only([
            'nombre',
            'tipo_categoria',
            'icono',
            'color_hex',
        ]));

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Elimina una categoría del usuario.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Eliminación de la categoría
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}