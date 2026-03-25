<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\Transaccion\FiltrarTransaccionRequest;
use App\Http\Requests\Transaccion\StoreTransaccionRequest;
use App\Http\Requests\Transaccion\UpdateTransaccionRequest;
use App\Models\Categoria;
use App\Models\CuentaFinanciera;
use App\Models\Transaccion;
use App\Services\TransaccionService;
use Illuminate\Support\Facades\Auth;

class TransaccionController extends Controller
{
    public function index(FiltrarTransaccionRequest $request, TransaccionService $transaccionService)
    {
        $idUsuario = Auth::user()->id_usuario;

        $datos = $transaccionService->obtenerDatosIndex(
            $idUsuario,
            $request->input('buscar'),
            $request->input('tipo')
        );

        return view('transacciones.index', $datos);
    }

    public function create()
    {
        $idUsuario = Auth::user()->id_usuario;

        $categorias = $this->obtenerCategoriasUsuario($idUsuario);
        $cuentas = $this->obtenerCuentasUsuario($idUsuario);

        return view('transacciones.create', compact('categorias', 'cuentas'));
    }

    public function store(StoreTransaccionRequest $request, TransaccionService $transaccionService)
    {
        $transaccion = Transaccion::create([
            'id_usuario' => Auth::user()->id_usuario,
            'id_cuenta' => $request->id_cuenta,
            'id_categoria' => $request->id_categoria,
            'tipo_movimiento' => $request->tipo_movimiento,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha_transaccion' => $request->fecha_transaccion,
            'metodo_pago' => $request->metodo_pago,
        ]);

        $transaccionService->recalcularSobresRelacionados($transaccion);

        return redirect()
            ->route('transacciones.index')
            ->with('success', MensajeHelper::creado('Transacción'));
    }

    public function show(string $id)
    {
        $transaccion = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('transacciones.show', compact('transaccion'));
    }

    public function edit(string $id)
    {
        $idUsuario = Auth::user()->id_usuario;

        $transaccion = $this->obtenerTransaccionUsuario($id);
        $categorias = $this->obtenerCategoriasUsuario($idUsuario);
        $cuentas = $this->obtenerCuentasUsuario($idUsuario);

        return view('transacciones.edit', compact('transaccion', 'categorias', 'cuentas'));
    }

    public function update(UpdateTransaccionRequest $request, string $id, TransaccionService $transaccionService)
    {
        $transaccion = $this->obtenerTransaccionUsuario($id);

        $categoriaAnterior = $transaccion->id_categoria;
        $fechaAnterior = $transaccion->fecha_transaccion;
        $tipoAnterior = $transaccion->tipo_movimiento;

        $transaccion->update([
            'id_cuenta' => $request->id_cuenta,
            'id_categoria' => $request->id_categoria,
            'tipo_movimiento' => $request->tipo_movimiento,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'fecha_transaccion' => $request->fecha_transaccion,
            'metodo_pago' => $request->metodo_pago,
        ]);

        $transaccionService->recalcularSobresRelacionados($transaccion);

        if (
            $categoriaAnterior != $transaccion->id_categoria ||
            $fechaAnterior != $transaccion->fecha_transaccion ||
            $tipoAnterior != $transaccion->tipo_movimiento
        ) {
            $transaccionService->recalcularSobresPorDatosAnteriores(
                Auth::user()->id_usuario,
                $categoriaAnterior,
                $fechaAnterior
            );
        }

        return redirect()
            ->route('transacciones.index')
            ->with('success', MensajeHelper::actualizado('Transacción'));
    }

    public function destroy(string $id, TransaccionService $transaccionService)
    {
        $transaccion = $this->obtenerTransaccionUsuario($id);

        $usuarioId = $transaccion->id_usuario;
        $categoriaId = $transaccion->id_categoria;
        $fecha = $transaccion->fecha_transaccion;

        $transaccion->delete();

        $transaccionService->recalcularSobresPorDatosAnteriores($usuarioId, $categoriaId, $fecha);

        return redirect()
            ->route('transacciones.index')
            ->with('success', MensajeHelper::eliminado('Transacción'));
    }

    private function obtenerTransaccionUsuario(string $id): Transaccion
    {
        return Transaccion::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }

    private function obtenerCategoriasUsuario(int $idUsuario)
    {
        return Categoria::where(function ($query) use ($idUsuario) {
                $query->whereNull('id_usuario')
                    ->orWhere('id_usuario', $idUsuario);
            })
            ->orderBy('nombre')
            ->get();
    }

    private function obtenerCuentasUsuario(int $idUsuario)
    {
        return CuentaFinanciera::where('id_usuario', $idUsuario)
            ->orderBy('nombre')
            ->get();
    }
}