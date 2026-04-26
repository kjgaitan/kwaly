<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
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

        return redirect()->route('login');
    }
}
