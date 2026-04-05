<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetaFinanciera\StoreMetaFinancieraRequest;
use App\Http\Requests\MetaFinanciera\UpdateMetaFinancieraRequest;
use App\Models\MetaFinanciera;
use App\Services\MetaFinancieraService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controlador encargado de gestionar las metas financieras.
 */
class MetaFinancieraController extends Controller
{
    /**
     * Constructor del controlador.
     */
    public function __construct(
        protected MetaFinancieraService $metaFinancieraService
    ) {
    }

    /**
     * Muestra el listado de metas con su resumen.
     */
    public function index(): View
    {
        $idUsuario = Auth::user()->id_usuario;

        $data = $this->metaFinancieraService->obtenerDatosVista($idUsuario);

        return view('metas.index', $data);
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create(): View
    {
        return view('metas.create');
    }

    /**
     * Guarda una nueva meta financiera.
     */
    public function store(StoreMetaFinancieraRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $datos['id_usuario'] = Auth::user()->id_usuario;

        if (!isset($datos['monto_actual'])) {
            $datos['monto_actual'] = 0;
        }

        if (!isset($datos['estado'])) {
            $datos['estado'] = 'activa';
        }

        MetaFinanciera::create($datos);

        return redirect()
            ->route('metas.index')
            ->with('success', 'Meta financiera registrada correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(MetaFinanciera $meta): View
    {
        $this->autorizarMeta($meta);

        return view('metas.edit', compact('meta'));
    }

    /**
     * Actualiza una meta financiera existente.
     */
    public function update(UpdateMetaFinancieraRequest $request, MetaFinanciera $meta): RedirectResponse
    {
        $this->autorizarMeta($meta);

        $meta->update($request->validated());

        return redirect()
            ->route('metas.index')
            ->with('success', 'Meta financiera actualizada correctamente.');
    }

    /**
     * Elimina una meta financiera.
     */
    public function destroy(MetaFinanciera $meta): RedirectResponse
    {
        $this->autorizarMeta($meta);

        $meta->delete();

        return redirect()
            ->route('metas.index')
            ->with('success', 'Meta financiera eliminada correctamente.');
    }

    /**
     * Comprueba que la meta pertenece al usuario autenticado.
     */
    private function autorizarMeta(MetaFinanciera $meta): void
    {
        abort_if($meta->id_usuario !== Auth::user()->id_usuario, 403);
    }
}