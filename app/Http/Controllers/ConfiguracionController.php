<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuracion\DeleteAccountRequest;
use App\Http\Requests\Configuracion\UpdateContrasenaRequest;
use App\Http\Requests\Configuracion\UpdateMonedaRequest;
use App\Http\Requests\Configuracion\UpdateNotificacionesRequest;
use App\Http\Requests\Configuracion\UpdatePerfilRequest;
use App\Models\Categoria;
use App\Services\ConfiguracionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConfiguracionController extends Controller
{
    public function __construct(
        protected ConfiguracionService $configuracionService
    ) {
    }

    public function index(): View
    {
        $usuario = Auth::user();
        $configuracion = $this->configuracionService->obtenerConfiguracion($usuario->id_usuario);

        $monedas = [
            'EUR' => 'EUR - Euro',
            'USD' => 'USD - Dolar estadounidense',
            'NIO' => 'NIO - Cordoba nicaraguense',
        ];

        $categorias = Categoria::where(function ($query) use ($usuario) {
                $query->whereNull('id_usuario')
                    ->orWhere('id_usuario', $usuario->id_usuario);
            })
            ->orderBy('nombre')
            ->get();

        return view('configuracion.index', compact(
            'usuario',
            'configuracion',
            'monedas',
            'categorias'
        ));
    }

    public function updatePerfil(UpdatePerfilRequest $request): RedirectResponse
    {
        $this->configuracionService->actualizarPerfil(Auth::user(), $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.perfil_actualizado'));
    }

    public function updateMoneda(UpdateMonedaRequest $request): RedirectResponse
    {
        $this->configuracionService->actualizarMoneda(Auth::user(), $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.moneda_actualizada'));
    }

    public function updateNotificaciones(UpdateNotificacionesRequest $request): RedirectResponse
    {
        $usuario = Auth::user();
        $configuracion = $this->configuracionService->obtenerConfiguracion($usuario->id_usuario);

        $this->configuracionService->actualizarNotificaciones($configuracion, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.notificaciones_actualizadas'));
    }

    public function updatePassword(UpdateContrasenaRequest $request): RedirectResponse
    {
        $this->configuracionService->actualizarPassword(Auth::user(), $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.password_actualizada'));
    }

    public function exportarDatos(): Response
    {
        $usuario = Auth::user();
        $datos = $this->configuracionService->obtenerDatosExportacion($usuario);

        return response(
            json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="kwaly-datos-usuario-' . $usuario->id_usuario . '.json"',
            ]
        );
    }

    public function destroyCuenta(DeleteAccountRequest $request): RedirectResponse
    {
        $this->configuracionService->eliminarCuentaUsuario(
            Auth::user(),
            $request->validated()['password_confirmacion']
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', __('messages.configuracion.cuenta_eliminada'));
    }
}
