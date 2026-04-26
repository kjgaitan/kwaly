<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Controlador encargado del registro de nuevos usuarios.
 *
 * Muestra el formulario de registro y guarda un nuevo usuario
 * en la tabla personalizada del sistema.
 */
class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gestiona la solicitud de registro de un nuevo usuario.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Creación del nuevo usuario en la tabla personalizada
        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'moneda_preferida' => 'EUR',
            'idioma_preferido' => 'es',
            'estado_cuenta' => 'activo',
            'fecha_registro' => now(),
            'ultimo_acceso' => now(),
        ]);

        event(new Registered($user));

        // Inicio de sesión automático tras el registro
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
