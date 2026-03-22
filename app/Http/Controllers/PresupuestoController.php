<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoMensual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar los presupuestos mensuales.
 */
class PresupuestoController extends Controller
{
    /**
     * Muestra el listado de presupuestos mensuales del usuario.
     */
    public function index()
    {
        $presupuestos = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('anio')
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
        $request->validate([
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|min:1|max:12',
            'ingreso_estimado' => 'nullable|numeric|min:0',
            'porcentaje_necesidades' => 'nullable|numeric|min:0|max:100',
            'porcentaje_deseos' => 'nullable|numeric|min:0|max:100',
            'porcentaje_ahorro' => 'nullable|numeric|min:0|max:100',
        ]);

        PresupuestoMensual::create([
            'id_usuario' => Auth::user()->id_usuario,
            'anio' => $request->anio,
            'mes' => $request->mes,
            'ingreso_estimado' => $request->ingreso_estimado,
            'porcentaje_necesidades' => $request->porcentaje_necesidades ?? 50,
            'porcentaje_deseos' => $request->porcentaje_deseos ?? 30,
            'porcentaje_ahorro' => $request->porcentaje_ahorro ?? 20,
        ]);

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Presupuesto creado correctamente.');
    }

    /**
     * Muestra el detalle de un presupuesto mensual específico.
     */
    public function show(int $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('presupuestos.show', compact('presupuesto'));
    }

    /**
     * Muestra el formulario para editar un presupuesto existente.
     */
    public function edit(int $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('presupuestos.edit', compact('presupuesto'));
    }

    /**
     * Actualiza los datos de un presupuesto mensual.
     */
    public function update(Request $request, int $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $request->validate([
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|min:1|max:12',
            'ingreso_estimado' => 'nullable|numeric|min:0',
            'porcentaje_necesidades' => 'nullable|numeric|min:0|max:100',
            'porcentaje_deseos' => 'nullable|numeric|min:0|max:100',
            'porcentaje_ahorro' => 'nullable|numeric|min:0|max:100',
        ]);

        $presupuesto->update([
            'anio' => $request->anio,
            'mes' => $request->mes,
            'ingreso_estimado' => $request->ingreso_estimado,
            'porcentaje_necesidades' => $request->porcentaje_necesidades,
            'porcentaje_deseos' => $request->porcentaje_deseos,
            'porcentaje_ahorro' => $request->porcentaje_ahorro,
        ]);

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Presupuesto actualizado correctamente.');
    }

    /**
     * Elimina un presupuesto mensual del usuario.
     */
    public function destroy(int $id)
    {
        $presupuesto = PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $presupuesto->delete();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Presupuesto eliminado correctamente.');
    }
}