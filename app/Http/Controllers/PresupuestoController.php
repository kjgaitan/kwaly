<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoMensual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar los presupuestos mensuales.
 * 
 * Permite al usuario crear, visualizar, editar y eliminar
 * presupuestos mensuales asociados a su cuenta.
 */
class PresupuestoController extends Controller
{
    /**
     * Muestra el listado de presupuestos mensuales del usuario.
     */
    public function index()
    {
        $presupuestos = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('mes')
            ->get();

        return view('presupuestos.index', compact('presupuestos'));
    }

    /**
     * Muestra el formulario para crear un nuevo presupuesto mensual.
     */
    public function create()
    {
        return view('presupuestos.create');
    }

    /**
     * Guarda un nuevo presupuesto mensual en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'mes' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
        ]);

        // Creación del presupuesto asociado al usuario autenticado
        PresupuestoMensual::create([
            'id_usuario' => Auth::user()->id_usuario,
            'mes' => $request->mes,
            'monto_total' => $request->monto_total,
        ]);

        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto creado correctamente.');
    }

    /**
     * Muestra el detalle de un presupuesto mensual específico.
     */
    public function show(string $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('presupuestos.show', compact('presupuesto'));
    }

    /**
     * Muestra el formulario para editar un presupuesto existente.
     */
    public function edit(string $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('presupuestos.edit', compact('presupuesto'));
    }

    /**
     * Actualiza los datos de un presupuesto mensual.
     */
    public function update(Request $request, string $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Validación de los datos enviados desde el formulario
        $request->validate([
            'mes' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
        ]);

        // Actualización del presupuesto mensual
        $presupuesto->update($request->only([
            'mes',
            'monto_total',
        ]));

        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto actualizado correctamente.');
    }

    /**
     * Elimina un presupuesto mensual del usuario.
     */
    public function destroy(string $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Eliminación del presupuesto
        $presupuesto->delete();

        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto eliminado correctamente.');
    }
}