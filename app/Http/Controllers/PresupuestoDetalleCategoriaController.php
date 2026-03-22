<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PresupuestoDetalleCategoria;
use App\Models\Categoria;
use App\Models\PresupuestoMensual;

class PresupuestoDetalleCategoriaController extends Controller
{
    public function create($presupuesto)
    {
        $presupuesto = PresupuestoMensual::findOrFail($presupuesto);

        $categorias = Categoria::where('id_usuario', Auth::id())
            ->orderBy('nombre')
            ->get();

        return view('sobres.create', compact('presupuesto', 'categorias'));
    }

    public function store(Request $request, $presupuesto)
    {
        $request->validate([
            'id_categoria'  => 'required|exists:categorias,id_categoria',
            'limite_monto'  => 'required|numeric|min:0',
            'monto_gastado' => 'nullable|numeric|min:0',
        ], [
            'id_categoria.required' => 'Debes seleccionar una categoría.',
            'id_categoria.exists'   => 'La categoría seleccionada no es válida.',
            'limite_monto.required' => 'Debes introducir el límite de monto.',
            'limite_monto.numeric'  => 'El límite de monto debe ser numérico.',
            'limite_monto.min'      => 'El límite de monto no puede ser negativo.',
            'monto_gastado.numeric' => 'El monto gastado debe ser numérico.',
            'monto_gastado.min'     => 'El monto gastado no puede ser negativo.',
        ]);

        $presupuesto = PresupuestoMensual::findOrFail($presupuesto);

        $categoria = Categoria::where('id_categoria', $request->id_categoria)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $existe = PresupuestoDetalleCategoria::where('id_presupuesto', $presupuesto->id_presupuesto)
            ->where('id_categoria', $categoria->id_categoria)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_categoria' => 'Esa categoría ya fue agregada a este presupuesto.',
                ]);
        }

        PresupuestoDetalleCategoria::create([
            'id_presupuesto' => $presupuesto->id_presupuesto,
            'id_categoria'   => $categoria->id_categoria,
            'limite_monto'   => $request->limite_monto,
            'monto_gastado'  => $request->filled('monto_gastado') ? $request->monto_gastado : 0,
        ]);

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Sobre creado correctamente.');
    }

    public function edit($detalle)
    {
        $detalle = PresupuestoDetalleCategoria::findOrFail($detalle);
        $presupuesto = PresupuestoMensual::findOrFail($detalle->id_presupuesto);

        $categorias = Categoria::where('id_usuario', Auth::id())
            ->orderBy('nombre')
            ->get();

        return view('sobres.edit', compact('detalle', 'presupuesto', 'categorias'));
    }

    public function update(Request $request, $detalle)
    {
        $request->validate([
            'id_categoria'  => 'required|exists:categorias,id_categoria',
            'limite_monto'  => 'required|numeric|min:0',
            'monto_gastado' => 'nullable|numeric|min:0',
        ], [
            'id_categoria.required' => 'Debes seleccionar una categoría.',
            'id_categoria.exists'   => 'La categoría seleccionada no es válida.',
            'limite_monto.required' => 'Debes introducir el límite de monto.',
            'limite_monto.numeric'  => 'El límite de monto debe ser numérico.',
            'limite_monto.min'      => 'El límite de monto no puede ser negativo.',
            'monto_gastado.numeric' => 'El monto gastado debe ser numérico.',
            'monto_gastado.min'     => 'El monto gastado no puede ser negativo.',
        ]);

        $detalle = PresupuestoDetalleCategoria::findOrFail($detalle);

        $categoria = Categoria::where('id_categoria', $request->id_categoria)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $existe = PresupuestoDetalleCategoria::where('id_presupuesto', $detalle->id_presupuesto)
            ->where('id_categoria', $categoria->id_categoria)
            ->where('id_detalle', '!=', $detalle->id_detalle)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'id_categoria' => 'Esa categoría ya fue agregada a este presupuesto.',
                ]);
        }

        $detalle->update([
            'id_categoria'  => $categoria->id_categoria,
            'limite_monto'  => $request->limite_monto,
            'monto_gastado' => $request->filled('monto_gastado') ? $request->monto_gastado : 0,
        ]);

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Sobre actualizado correctamente.');
    }

    public function destroy($detalle)
    {
        $detalle = PresupuestoDetalleCategoria::findOrFail($detalle);
        $detalle->delete();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', 'Sobre eliminado correctamente.');
    }
}