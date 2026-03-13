<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CuentaFinanciera;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las transacciones del usuario.
 */
class TransaccionController extends Controller
{
    /**
     * Muestra el listado de transacciones.
     */
    public function index()
    {
        $transacciones = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('fecha_transaccion')
            ->get();

        return view('transacciones.index', compact('transacciones'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $categorias = Categoria::where(function ($query) {
                $query->whereNull('id_usuario')
                      ->orWhere('id_usuario', Auth::user()->id_usuario);
            })
            ->orderBy('nombre')
            ->get();

        $cuentas = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('nombre')
            ->get();

        return view('transacciones.create', compact('categorias', 'cuentas'));
    }

    /**
     * Guarda una nueva transacción.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cuenta' => 'nullable|exists:cuentas_financieras,id_cuenta',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'tipo_movimiento' => 'required|in:ingreso,gasto',
            'titulo' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_transaccion' => 'required|date',
            'metodo_pago' => 'nullable|string|max:50',
        ]);

        Transaccion::create([
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

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción registrada correctamente.');
    }

    /**
     * Muestra una transacción concreta.
     */
    public function show(string $id)
    {
        $transaccion = Transaccion::with(['categoria', 'cuenta'])
            ->where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('transacciones.show', compact('transaccion'));
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(string $id)
    {
        $transaccion = Transaccion::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $categorias = Categoria::where(function ($query) {
                $query->whereNull('id_usuario')
                      ->orWhere('id_usuario', Auth::user()->id_usuario);
            })
            ->orderBy('nombre')
            ->get();

        $cuentas = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('nombre')
            ->get();

        return view('transacciones.edit', compact('transaccion', 'categorias', 'cuentas'));
    }

    /**
     * Actualiza una transacción existente.
     */
    public function update(Request $request, string $id)
    {
        $transaccion = Transaccion::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $request->validate([
            'id_cuenta' => 'nullable|exists:cuentas_financieras,id_cuenta',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'tipo_movimiento' => 'required|in:ingreso,gasto',
            'titulo' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_transaccion' => 'required|date',
            'metodo_pago' => 'nullable|string|max:50',
        ]);

        $transaccion->update($request->only([
            'id_cuenta',
            'id_categoria',
            'tipo_movimiento',
            'titulo',
            'descripcion',
            'monto',
            'fecha_transaccion',
            'metodo_pago',
        ]));

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción actualizada correctamente.');
    }

    /**
     * Elimina una transacción.
     */
    public function destroy(string $id)
    {
        $transaccion = Transaccion::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        $transaccion->delete();

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción eliminada correctamente.');
    }
}