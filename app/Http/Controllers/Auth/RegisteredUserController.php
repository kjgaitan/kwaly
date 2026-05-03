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

class UsuarioRegistradoController extends Controller
{
    /**
     * Mostrar formulario de registro
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Registrar nuevo usuario
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'max:150',
                'email:rfc,dns',
                'unique:usuarios,email',
                'not_regex:/@(gmai|gmial|gmail\.con|hotmial|hotmai|outlok|outlook\.con)/i',
            ],

            'telefono' => [
                'nullable',
                'regex:/^[0-9]+$/',
                'min:7',
                'max:15',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Introduce un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.not_regex' => 'El dominio del correo no es válido.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'telefono.min' => 'El teléfono debe tener al menos 7 dígitos.',
            'telefono.max' => 'El teléfono no puede superar los 15 dígitos.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'email' => strtolower($request->email),
            'password_hash' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'moneda_preferida' => 'EUR',
            'idioma_preferido' => 'es',
            'estado_cuenta' => 'activo',
            'fecha_registro' => now(),
            'ultimo_acceso' => now(),
        ]);

        event(new Registered($user));

        // Login automático
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Cuenta creada correctamente.');
    }
}