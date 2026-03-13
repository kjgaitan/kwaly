<?php

namespace App\Http\Controllers;

use App\Models\CuentaFinanciera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las cuentas financieras.
 * 
 * Permite al usuario autenticado crear, visualizar,
 * editar y eliminar sus cuentas financieras.
 */
class CuentaFinancieraController extends Controller
{
    /**
     * Muestra el listado de cuentas financieras del usuario.
     */
    public function index()
    {
        $cuentas = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('nombre')
            ->get();

        return view('cuentas_financieras.index', compact('cuentas'));
    }

    /**
     * Muestra el formulario para crear una nueva cuenta financiera.
     */
    public function create()
    {
        return view('cuentas_financieras.create');
    }

    /**
     * Guarda una nueva cuenta financiera en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_cuenta' => 'nullable|in:efectivo,banco,tarjeta,ahorro,otro',
            'saldo_actual' => 'nullable|numeric|min:0',
            'moneda' => 'nullable|string|max:3',
        ]);

        // Creación de la cuenta financiera asociada al usuario autenticado
        CuentaFinanciera::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre' => $request->nombre,
            'tipo_cuenta' => $request->tipo_cuenta,
            'saldo_actual' => $request->saldo_actual ?? 0,
            'moneda' => $request->moneda ?? 'EUR',
        ]);

        return redirect()->route('cuentas-financieras.index')
            ->with('success', 'Cuenta financiera creada correctamente.');
    }

    /**
     * Muestra el detalle de una cuenta financiera específica.
     */
    public function show(string $id)
    {
        $cuenta = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('cuentas_financieras.show', compact('cuenta'));
    }

    /**
     * Muestra el formulario para editar una cuenta financiera existente.
     */
    public function edit(string $id)
    {
        $cuenta = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        return view('cuentas_financieras.edit', compact('cuenta'));
    }

    /**
     * Actualiza los datos de una cuenta financiera.
     */
    public function update(Request $request, string $id)
    {
        $cuenta = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_cuenta' => 'nullable|in:efectivo,banco,tarjeta,ahorro,otro',
            'saldo_actual' => 'nullable|numeric|min:0',
            'moneda' => 'nullable|string|max:3',
        ]);

        // Actualización de la cuenta financiera
        $cuenta->update($request->only([
            'nombre',
            'tipo_cuenta',
            'saldo_actual',
            'moneda',
        ]));

        return redirect()->route('cuentas-financieras.index')
            ->with('success', 'Cuenta financiera actualizada correctamente.');
    }

    /**
     * Elimina una cuenta financiera del usuario.
     */
    public function destroy(string $id)
    {
        $cuenta = CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);

        // Eliminación de la cuenta financiera
        $cuenta->delete();

        return redirect()->route('cuentas-financieras.index')
            ->with('success', 'Cuenta financiera eliminada correctamente.');
    }
}