<?php

namespace App\Http\Controllers;

use App\Models\MetaFinanciera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las metas financieras.
 * 
 * Permite al usuario crear, visualizar, editar y eliminar
 * metas financieras asociadas a su cuenta.
 */
class MetaFinancieraController extends Controller
{
    /**
     * Muestra el listado de metas financieras del usuario.
     */
    public function index()
    {
        $metas = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('metas.index', compact('metas'));
    }

    /**
     * Muestra el formulario para crear una nueva meta financiera.
     */
    public function create()
    {
        return view('metas.create');
    }

    /**
     * Guarda una nueva meta financiera en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre_meta' => 'required|string|max:150',
            'monto_objetivo' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        // Creación de la meta asociada al usuario autenticado
        MetaFinanciera::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre_meta' => $request->nombre_meta,
            'monto_objetivo' => $request->monto_objetivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('metas.index')
            ->with('success', 'Meta financiera creada correctamente.');
    }

    /**
     * Muestra el detalle de una meta financiera específica.
     */
    public function show(string $id)
    {
        $meta = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('metas.show', compact('meta'));
    }

    /**
     * Muestra el formulario para editar una meta financiera existente.
     */
    public function edit(string $id)
    {
        $meta = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('metas.edit', compact('meta'));
    }

    /**
     * Actualiza los datos de una meta financiera.
     */
    public function update(Request $request, string $id)
    {
        $meta = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre_meta' => 'required|string|max:150',
            'monto_objetivo' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        // Actualización de los datos de la meta financiera
        $meta->update($request->only([
            'nombre_meta',
            'monto_objetivo',
            'fecha_inicio',
            'fecha_fin',
        ]));

        return redirect()->route('metas.index')
            ->with('success', 'Meta financiera actualizada correctamente.');
    }

    /**
     * Elimina una meta financiera del usuario.
     */
    public function destroy(string $id)
    {
        $meta = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Eliminación de la meta financiera
        $meta->delete();

        return redirect()->route('metas.index')
            ->with('success', 'Meta eliminada correctamente.');
    }
}