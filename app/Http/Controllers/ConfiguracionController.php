<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar la configuración del usuario.
 */
class ConfiguracionController extends Controller
{
    /**
     * Muestra la configuración del usuario autenticado.
     */
    public function index()
    {
        $configuracion = ConfiguracionUsuario::where('id_usuario', Auth::user()->id_usuario)
            ->first();

        return view('configuracion.index', compact('configuracion'));
    }

    /**
     * Actualiza la configuración del usuario.
     */
    public function update(Request $request)
    {
        $request->validate([
            'tema' => 'nullable|string|max:50',
            'notificaciones_email' => 'nullable|boolean',
            'notificaciones_push' => 'nullable|boolean',
            'moneda_preferida' => 'nullable|string|max:3',
        ]);

        $configuracion = ConfiguracionUsuario::firstOrCreate([
            'id_usuario' => Auth::user()->id_usuario
        ]);

        $configuracion->update([
            'tema' => $request->tema,
            'notificaciones_email' => $request->notificaciones_email ?? false,
            'notificaciones_push' => $request->notificaciones_push ?? false,
            'moneda_preferida' => $request->moneda_preferida ?? 'EUR',
        ]);

        return redirect()->route('configuracion.index')
            ->with('success', 'Configuración actualizada correctamente.');
    }
}