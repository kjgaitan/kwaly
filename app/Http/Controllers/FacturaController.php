<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\Factura\StoreFacturaRequest;
use App\Http\Requests\Factura\UpdateFacturaRequest;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    /**
     * Muestra el listado de facturas del usuario.
     */
    public function index()
    {
        $facturas = Factura::where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        $hoy = now()->toDateString();

        foreach ($facturas as $factura) {
            if ($factura->estado !== 'pagada' && $factura->fecha_vencimiento < $hoy) {
                $factura->estado_visual = 'vencida';
            } else {
                $factura->estado_visual = $factura->estado;
            }
        }

        $facturasPendientes = $facturas->filter(function ($factura) {
            return $factura->estado_visual === 'pendiente' || $factura->estado_visual === 'vencida';
        });

        $facturasPagadas = $facturas->filter(function ($factura) {
            return $factura->estado_visual === 'pagada';
        });

        $totalPendiente = $facturasPendientes->sum('monto_total');
        $cantidadPendientes = $facturasPendientes->count();

        $totalPagado = $facturasPagadas->sum('monto_total');
        $cantidadPagadas = $facturasPagadas->count();

        $totalGeneral = $facturas->sum('monto_total');
        $cantidadTotal = $facturas->count();

        $porcentajePagado = $totalGeneral > 0
            ? round(($totalPagado / $totalGeneral) * 100, 1)
            : 0;

        return view('facturas.index', compact(
            'facturas',
            'totalPendiente',
            'cantidadPendientes',
            'totalPagado',
            'cantidadPagadas',
            'totalGeneral',
            'cantidadTotal',
            'porcentajePagado'
        ));
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
            'proveedor' => $request->proveedor,
            'concepto' => $request->concepto,
            'descripcion' => $request->descripcion,
            'monto_total' => $request->monto_total,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'fecha_pago' => $request->estado === 'pagada' ? now()->toDateString() : null,
            'estado' => $request->estado ?? 'pendiente',
            'frecuencia' => $request->frecuencia ?? 'unica',
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

        $datosActualizar = [
            'proveedor' => $request->proveedor,
            'concepto' => $request->concepto,
            'descripcion' => $request->descripcion,
            'monto_total' => $request->monto_total,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado' => $request->estado ?? 'pendiente',
            'frecuencia' => $request->frecuencia ?? 'unica',
        ];

        if (($request->estado ?? 'pendiente') === 'pagada') {
            $datosActualizar['fecha_pago'] = now()->toDateString();
        } else {
            $datosActualizar['fecha_pago'] = null;
        }

        $factura->update($datosActualizar);

        return redirect()
            ->route('facturas.index')
            ->with('success', MensajeHelper::actualizado('Factura'));
    }

    /**
     * Marca una factura como pagada.
     */
    public function marcarPagada(string $id)
    {
        $factura = $this->obtenerFacturaUsuario($id);

        $factura->update([
            'estado' => 'pagada',
            'fecha_pago' => now()->toDateString(),
        ]);

        return redirect()
            ->route('facturas.index')
            ->with('success', 'Factura marcada como pagada correctamente.');
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
     * Obtiene una factura del usuario autenticado.
     */
    private function obtenerFacturaUsuario(string $id): Factura
    {
        return Factura::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }
}