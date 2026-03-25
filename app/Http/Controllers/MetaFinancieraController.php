<?php

namespace App\Http\Controllers;

use App\Helpers\MensajeHelper;
use App\Http\Requests\MetaFinanciera\StoreMetaFinancieraRequest;
use App\Http\Requests\MetaFinanciera\UpdateMetaFinancieraRequest;
use App\Models\MetaFinanciera;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las metas financieras.
 *
 * Permite al usuario crear, visualizar, editar y eliminar
 * metas financieras asociadas a su cuenta.
 */
class MetaFinancieraController extends Controller
{
    /**
     * Muestra el listado de metas financieras del usuario.
     */
    public function index()
    {
        $metas = MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('metas.index', compact('metas'));
    }

    /**
     * Muestra el formulario para crear una nueva meta financiera.
     */
    public function create()
    {
        return view('metas.create');
    }

    /**
     * Guarda una nueva meta financiera en la base de datos.
     */
    public function store(StoreMetaFinancieraRequest $request)
    {
        MetaFinanciera::create([
            'id_usuario' => Auth::user()->id_usuario,
            'nombre_meta' => $request->nombre_meta,
            'monto_objetivo' => $request->monto_objetivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()
            ->route('metas.index')
            ->with('success', MensajeHelper::creado('Meta financiera'));
    }

    /**
     * Muestra el detalle de una meta financiera específica.
     */
    public function show(string $id)
    {
        $meta = $this->obtenerMetaUsuario($id);

        return view('metas.show', compact('meta'));
    }

    /**
     * Muestra el formulario para editar una meta financiera existente.
     */
    public function edit(string $id)
    {
        $meta = $this->obtenerMetaUsuario($id);

        return view('metas.edit', compact('meta'));
    }

    /**
     * Actualiza los datos de una meta financiera.
     */
    public function update(UpdateMetaFinancieraRequest $request, string $id)
    {
        $meta = $this->obtenerMetaUsuario($id);

        $meta->update([
            'nombre_meta' => $request->nombre_meta,
            'monto_objetivo' => $request->monto_objetivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()
            ->route('metas.index')
            ->with('success', MensajeHelper::actualizado('Meta financiera'));
    }

    /**
     * Elimina una meta financiera del usuario.
     */
    public function destroy(string $id)
    {
        $meta = $this->obtenerMetaUsuario($id);

        $meta->delete();

        return redirect()
            ->route('metas.index')
            ->with('success', MensajeHelper::eliminado('Meta financiera'));
    }

    /**
     * Obtiene una meta financiera perteneciente al usuario autenticado.
     */
    private function obtenerMetaUsuario(string $id): MetaFinanciera
    {
        return MetaFinanciera::where('id_usuario', Auth::user()->id_usuario)
            ->findOrFail($id);
    }
}