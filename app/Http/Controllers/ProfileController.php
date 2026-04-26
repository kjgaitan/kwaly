<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuracion\UpdatePasswordRequest;
use App\Http\Requests\Configuracion\UpdatePerfilRequest;
use App\Services\ConfiguracionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected ConfiguracionService $configuracionService
    ) {
    }

    public function edit(): View
    {
        return view('profile.edit', [
            'usuario' => Auth::user(),
        ]);
    }

    public function update(UpdatePerfilRequest $request): RedirectResponse
    {
        $datosPerfil = $request->validated();
        $actualizarPassword = $request->filled('password_actual')
            || $request->filled('password_nueva')
            || $request->filled('password_nueva_confirmation');

        $datosPassword = [];

        if ($actualizarPassword) {
            $datosPassword = $request->validate([
                'password_actual' => ['required'],
                'password_nueva' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'password_actual.required' => 'La contrasena actual es obligatoria.',
                'password_nueva.required' => 'La nueva contrasena es obligatoria.',
                'password_nueva.min' => 'La nueva contrasena debe tener al menos 8 caracteres.',
                'password_nueva.confirmed' => 'La confirmacion de la nueva contrasena no coincide.',
            ]);
        }

        DB::transaction(function () use ($datosPerfil, $datosPassword, $actualizarPassword) {
            $usuario = Auth::user();

            $this->configuracionService->actualizarPerfil($usuario, $datosPerfil);

            if ($actualizarPassword) {
                $this->configuracionService->actualizarPassword($usuario, $datosPassword);
            }
        });

        return redirect()
            ->route('profile.edit')
            ->with('success', $actualizarPassword
                ? 'Perfil y contrasena actualizados correctamente.'
                : 'Perfil actualizado correctamente.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->configuracionService->actualizarPassword(Auth::user(), $request->validated());

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Contrasena actualizada correctamente.');
    }
}
