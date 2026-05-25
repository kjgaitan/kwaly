<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\Presupuesto\StorePresupuestoRequest;
use App\Http\Requests\Presupuesto\UpdatePresupuestoRequest;
use App\Models\PresupuestoMensual;
use App\Services\PresupuestoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PresupuestoDetalleCategoria;

/**
 * Controlador encargado de gestionar los presupuestos mensuales.
 */
class PresupuestoController extends Controller
{
    /**
     * Muestra el listado de presupuestos mensuales del usuario.
     */
    public function index(PresupuestoService $presupuestoService)
    {
        $usuarioId = Auth::user()->id_usuario;
        $presupuestoActivoId = session('presupuesto_activo_id');

        $datos = $presupuestoService->obtenerDatosIndex($usuarioId, $presupuestoActivoId);

        return view('presupuestos.index', $datos);
    }

    /**
     * Selecciona el presupuesto activo para mostrar sus datos en el índice.
     */
    public function select(Request $request)
    {
        $request->validate([
            'id_presupuesto' => 'required|integer',
        ]);

        $presupuesto = $this->obtenerPresupuestoUsuario($request->input('id_presupuesto'));

        session(['presupuesto_activo_id' => $presupuesto->id_presupuesto]);

        return redirect()->route('presupuestos.index');
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
    public function store(StorePresupuestoRequest $request)
    {
        $datos = $request->validated();
        $datos['id_usuario'] = Auth::user()->id_usuario;

        PresupuestoMensual::create($datos);

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::creado('Presupuesto'));
    }

    /**
     * Muestra el detalle de un presupuesto mensual específico.
     */
    public function show(int $id)
    {
        $presupuesto = $this->obtenerPresupuestoUsuario($id);

        return view('presupuestos.show', compact('presupuesto'));
    }

    /**
     * Muestra el formulario para editar un presupuesto existente.
     */
    public function edit(int $id)
    {
        $presupuesto = $this->obtenerPresupuestoUsuario($id);

        return view('presupuestos.edit', compact('presupuesto'));
    }

    /**
     * Actualiza los datos de un presupuesto mensual.
     */
    public function update(UpdatePresupuestoRequest $request, int $id)
    {
        $presupuesto = $this->obtenerPresupuestoUsuario($id);

        $presupuesto->update($request->validated());

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::actualizado('Presupuesto'));
    }

    /**
     * Elimina un presupuesto mensual del usuario.
     */
    public function destroy(int $id)
    {
        $presupuesto = $this->obtenerPresupuestoUsuario($id);

        PresupuestoDetalleCategoria::where('id_presupuesto', $presupuesto->id_presupuesto)->delete();

        $presupuesto->delete();

        return redirect()
            ->route('presupuestos.index')
            ->with('success', MensajeHelper::eliminado('Presupuesto'));
    }

    /**
     * Obtiene un presupuesto perteneciente al usuario autenticado.
     */
    private function obtenerPresupuestoUsuario(int $id): PresupuestoMensual
    {
        return PresupuestoMensual::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }
}