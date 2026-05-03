<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuracion\DeleteAccountRequest;
use App\Http\Requests\Configuracion\UpdateMonedaRequest;
use App\Http\Requests\Configuracion\UpdateNotificacionesRequest;
use App\Http\Requests\Configuracion\UpdateContrasenaRequest;
use App\Http\Requests\Configuracion\UpdatePerfilRequest;
use App\Services\ConfiguracionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controlador encargado de la configuración del usuario.
 */
class ConfiguracionController extends Controller
{
    /**
     * Constructor del controlador.
     */
    public function __construct(
        protected ConfiguracionService $configuracionService
    ) {
    }

    /**
     * Muestra la vista principal de configuración.
     */
    public function index(): View
    {
        $usuario = Auth::user();
        $configuracion = $this->configuracionService->obtenerConfiguracion($usuario->id_usuario);

        $monedas = [
            'EUR' => 'EUR - Euro',
            'USD' => 'USD - Dólar estadounidense',
            'NIO' => 'NIO - Córdoba nicaragüense',
        ];

        return view('configuracion.index', compact(
            'usuario',
            'configuracion',
            'monedas'
        ));
    }

    /**
     * Actualiza los datos del perfil.
     */
    public function updatePerfil(UpdatePerfilRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        $this->configuracionService->actualizarPerfil($usuario, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.perfil_actualizado'));
    }

    /**
     * Actualiza la moneda principal del usuario.
     */
    public function updateMoneda(UpdateMonedaRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        $this->configuracionService->actualizarMoneda($usuario, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.moneda_actualizada'));
    }

    /**
     * Actualiza únicamente las notificaciones.
     */
    public function updateNotificaciones(UpdateNotificacionesRequest $request): RedirectResponse
    {
        $usuario = Auth::user();
        $configuracion = $this->configuracionService->obtenerConfiguracion($usuario->id_usuario);

        $this->configuracionService->actualizarNotificaciones($configuracion, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.notificaciones_actualizadas'));
    }

    /**
     * Actualiza únicamente la configuración de autenticación 2FA.
     */
    public function updateSeguridad(UpdateNotificacionesRequest $request): RedirectResponse
    {
        $usuario = Auth::user();
        $configuracion = $this->configuracionService->obtenerConfiguracion($usuario->id_usuario);

        $this->configuracionService->actualizarSeguridad($configuracion, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.seguridad_actualizada'));
    }

    /**
     * Actualiza la contraseña del usuario autenticado.
     */
    public function updatePassword(UpdateContrasenaRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        $this->configuracionService->actualizarPassword($usuario, $request->validated());

        return redirect()
            ->route('configuracion.index')
            ->with('success', __('messages.configuracion.password_actualizada'));
    }

    /**
     * Exporta los datos del usuario autenticado en formato JSON.
     */
    public function exportarDatos(): Response
    {
        $usuario = Auth::user();
        $datos = $this->configuracionService->obtenerDatosExportacion($usuario);

        $nombreArchivo = 'kwaly-datos-usuario-' . $usuario->id_usuario . '.json';

        return response(
            json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
            ]
        );
    }

    /**
     * Elimina la cuenta del usuario autenticado.
     */
    public function destroyCuenta(DeleteAccountRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        $this->configuracionService->eliminarCuentaUsuario(
            $usuario,
            $request->validated()['password_confirmacion']
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', __('messages.configuracion.cuenta_eliminada'));
    }
} 