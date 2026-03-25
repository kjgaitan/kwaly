<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\Factura\StoreFacturaRequest;
use App\Http\Requests\Factura\UpdateFacturaRequest;
use App\Models\Factura;
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
    public function store(StoreFacturaRequest $request)
    {
        Factura::create([
            'id_usuario' => Auth::user()->id_usuario,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha_emision' => $request->fecha_emision,
            'estado' => $request->estado ?? 'pendiente',
        ]);

        return redirect()
            ->route('facturas.index')
            ->with('success', MensajeHelper::creado('Factura'));
    }

    /**
     * Muestra el detalle de una factura específica.
     */
    public function show(string $id)
    {
        $factura = $this->obtenerFacturaUsuario($id);

        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar una factura existente.
     */
    public function edit(string $id)
    {
        $factura = $this->obtenerFacturaUsuario($id);

        return view('facturas.edit', compact('factura'));
    }

    /**
     * Actualiza los datos de una factura.
     */
    public function update(UpdateFacturaRequest $request, string $id)
    {
        $factura = $this->obtenerFacturaUsuario($id);

        $factura->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha_emision' => $request->fecha_emision,
            'estado' => $request->estado ?? 'pendiente',
        ]);

        return redirect()
            ->route('facturas.index')
            ->with('success', MensajeHelper::actualizado('Factura'));
    }

    /**
     * Elimina una factura del usuario.
     */
    public function destroy(string $id)
    {
        $factura = $this->obtenerFacturaUsuario($id);

        $factura->delete();

        return redirect()
            ->route('facturas.index')
            ->with('success', MensajeHelper::eliminado('Factura'));
    }

    /**
     * Obtiene una factura perteneciente al usuario autenticado.
     */
    private function obtenerFacturaUsuario(string $id): Factura
    {
        return Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }
}