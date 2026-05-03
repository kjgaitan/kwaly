<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de mostrar el panel principal de la aplicación.
 *
 * Este controlador reúne la información más relevante del usuario
 * para mostrarla en el dashboard.
 */
class PanelController extends Controller
{
    /**
     * Muestra el resumen general del usuario autenticado.
     */
    public function index(DashboardService $dashboardService)
    {
        $usuario = Auth::user();

        $datosDashboard = $dashboardService->obtenerResumen($usuario->id_usuario);

        return view('dashboard.index', $datosDashboard);
    }
}
