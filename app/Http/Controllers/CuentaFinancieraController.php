<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\CuentaFinanciera\StoreCuentaFinancieraRequest;
use App\Http\Requests\CuentaFinanciera\UpdateCuentaFinancieraRequest;
use App\Models\CuentaFinanciera;
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
    public function store(StoreCuentaFinancieraRequest $request)
    {
        CuentaFinanciera::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre' => $request->nombre,
            'tipo_cuenta' => $request->tipo_cuenta,
            'saldo_actual' => $request->saldo_actual ?? 0,
            'moneda' => $request->moneda ?? 'EUR',
        ]);

        return redirect()
            ->route('cuentas-financieras.index')
            ->with('success', MensajeHelper::creado('Cuenta financiera'));
    }

    /**
     * Muestra el detalle de una cuenta financiera específica.
     */
    public function show(string $id)
    {
        $cuenta = $this->obtenerCuentaUsuario($id);

        return view('cuentas_financieras.show', compact('cuenta'));
    }

    /**
     * Muestra el formulario para editar una cuenta financiera existente.
     */
    public function edit(string $id)
    {
        $cuenta = $this->obtenerCuentaUsuario($id);

        return view('cuentas_financieras.edit', compact('cuenta'));
    }

    /**
     * Actualiza los datos de una cuenta financiera.
     */
    public function update(UpdateCuentaFinancieraRequest $request, string $id)
    {
        $cuenta = $this->obtenerCuentaUsuario($id);

        $cuenta->update([
            'nombre' => $request->nombre,
            'tipo_cuenta' => $request->tipo_cuenta,
            'saldo_actual' => $request->saldo_actual ?? 0,
            'moneda' => $request->moneda ?? 'EUR',
        ]);

        return redirect()
            ->route('cuentas-financieras.index')
            ->with('success', MensajeHelper::actualizado('Cuenta financiera'));
    }

    /**
     * Elimina una cuenta financiera del usuario.
     */
    public function destroy(string $id)
    {
        $cuenta = $this->obtenerCuentaUsuario($id);

        $cuenta->delete();

        return redirect()
            ->route('cuentas-financieras.index')
            ->with('success', MensajeHelper::eliminado('Cuenta financiera'));
    }

    /**
     * Obtiene una cuenta financiera perteneciente al usuario autenticado.
     */
    private function obtenerCuentaUsuario(string $id): CuentaFinanciera
    {
        return CuentaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }
}