<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
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
class UsuarioRegistradoController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('autenticacion.register');
    }

    /**
     * Gestiona la solicitud de registro de un nuevo usuario.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Guardar valores de contraseñas en sesión por si hay errores
        if ($request->password) {
            session()->flash('password', $request->password);
        }
        if ($request->password_confirmation) {
            session()->flash('password_confirmation', $request->password_confirmation);
        }

        // Validación de los datos enviados desde el formulario
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'max:150',
                'email',
                'unique:usuarios,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com|yahoo\.com|icloud\.com|proton\.me|hotmail\.es|outlook\.es|yahoo\.es|[a-zA-Z0-9-]+\.edu|[a-zA-Z0-9-]+\.es)$/',
            ],
            'telefono' => [
                'required',
                'regex:/^[0-9]+$/',
                'min:9',
                'max:15',
            ],
            'password_confirmation' => [
                'required',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe introducir un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'email.regex' => 'Solo se permiten correos de dominios autorizados (gmail, outlook, hotmail, yahoo, icloud, proton, .es, .edu, .com).',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'telefono.min' => 'El teléfono debe tener al menos 9 dígitos.',
            'telefono.max' => 'El teléfono no puede superar los 15 dígitos.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password_confirmation.required' => 'Debe confirmar la contraseña.',
        ]);

        // Creación del nuevo usuario en la tabla personalizada
        $user = Usuario::create([
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
