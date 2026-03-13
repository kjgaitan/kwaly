<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las facturas del usuario.
 * 
 * Permite crear, visualizar, editar y eliminar facturas
 * asociadas al usuario autenticado.
 */
class FacturaController extends Controller
{
    /**
     * Muestra el listado de facturas del usuario.
     */
    public function index()
    {
        $facturas = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('fecha_emision')
            ->get();

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Muestra el formulario para registrar una nueva factura.
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Guarda una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date',
            'estado' => 'nullable|string|max:50',
        ]);

        // Creación de la factura asociada al usuario autenticado
        Factura::create([
            'id_usuario' => Auth::user()->id_usuario,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha_emision' => $request->fecha_emision,
            'estado' => $request->estado ?? 'pendiente',
        ]);

        return redirect()->route('facturas.index')
            ->with('success', 'Factura registrada correctamente.');
    }

    /**
     * Muestra el detalle de una factura específica.
     */
    public function show(string $id)
    {
        $factura = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar una factura existente.
     */
    public function edit(string $id)
    {
        $factura = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('facturas.edit', compact('factura'));
    }

    /**
     * Actualiza los datos de una factura.
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Validación de los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date',
            'estado' => 'nullable|string|max:50',
        ]);

        // Actualización de los datos de la factura
        $factura->update($request->only([
            'titulo',
            'descripcion',
            'monto',
            'fecha_emision',
            'estado',
        ]));

        return redirect()->route('facturas.index')
            ->with('success', 'Factura actualizada correctamente.');
    }

    /**
     * Elimina una factura del usuario.
     */
    public function destroy(string $id)
    {
        $factura = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Eliminación de la factura
        $factura->delete();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada correctamente.');
    }
}