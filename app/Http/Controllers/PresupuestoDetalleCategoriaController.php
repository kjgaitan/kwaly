<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\PresupuestoDetalleCategoria\StorePresupuestoDetalleCategoriaRequest;
use App\Http\Requests\PresupuestoDetalleCategoria\UpdatePresupuestoDetalleCategoriaRequest;
use App\Models\Categoria;
use App\Models\PresupuestoDetalleCategoria;
use App\Models\PresupuestoMensual;
use Illuminate\Support\Facades\Auth;

class PresupuestoDetalleCategoriaController extends Controller
{
    public function create($presupuesto)
    {
        $usuarioId = Auth::user()->id_usuario;

        $presupuesto = $this->obtenerPresupuestoUsuario($presupuesto, $usuarioId);

        $categorias = Categoria::where('id_usuario', $usuarioId)
            ->orderBy('nombre')
            ->get();

        return view('sobres.create', compact('presupuesto', 'categorias'));
    }

    public function store(StorePresupuestoDetalleCategoriaRequest $request, $presupuesto)
    {
        $usuarioId = Auth::user()->id_usuario;

        $presupuesto = $this->obtenerPresupuestoUsuario($presupuesto, $usuarioId);
        $categoria = $this->obtenerCategoriaUsuario($request->id_categoria, $usuarioId);

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

        $detalle = PresupuestoDetalleCategoria::create([
            'id_presupuesto' => $presupuesto->id_presupuesto,
            'id_categoria' => $categoria->id_categoria,
            'limite_monto' => $request->limite_monto,
            'monto_gastado' => 0,
        ]);

        $detalle->recalcularMontoGastado();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::creado('Sobre'));
    }

    public function edit($detalle)
    {
        $usuarioId = Auth::user()->id_usuario;

        $detalle = $this->obtenerDetalleUsuario($detalle, $usuarioId);

        $presupuesto = $this->obtenerPresupuestoUsuario($detalle->id_presupuesto, $usuarioId);

        $categorias = Categoria::where('id_usuario', $usuarioId)
            ->orderBy('nombre')
            ->get();

        return view('sobres.edit', compact('detalle', 'presupuesto', 'categorias'));
    }

    public function update(UpdatePresupuestoDetalleCategoriaRequest $request, $detalle)
    {
        $usuarioId = Auth::user()->id_usuario;

        $detalle = $this->obtenerDetalleUsuario($detalle, $usuarioId);
        $categoria = $this->obtenerCategoriaUsuario($request->id_categoria, $usuarioId);

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
            'id_categoria' => $categoria->id_categoria,
            'limite_monto' => $request->limite_monto,
        ]);

        $detalle->recalcularMontoGastado();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::actualizado('Sobre'));
    }

    public function destroy($detalle)
    {
        $usuarioId = Auth::user()->id_usuario;

        $detalle = $this->obtenerDetalleUsuario($detalle, $usuarioId);

        $detalle->delete();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::eliminado('Sobre'));
    }

    private function obtenerPresupuestoUsuario($idPresupuesto, int $usuarioId): PresupuestoMensual
    {
        return PresupuestoMensual::where('id_usuario', $usuarioId)
            ->findOrFail($idPresupuesto);
    }

    private function obtenerCategoriaUsuario($idCategoria, int $usuarioId): Categoria
    {
        return Categoria::where('id_categoria', $idCategoria)
            ->where('id_usuario', $usuarioId)
            ->firstOrFail();
    }

    private function obtenerDetalleUsuario($idDetalle, int $usuarioId): PresupuestoDetalleCategoria
    {
        return PresupuestoDetalleCategoria::whereHas('presupuesto', function ($query) use ($usuarioId) {
            $query->where('id_usuario', $usuarioId);
        })->findOrFail($idDetalle);
    }
}