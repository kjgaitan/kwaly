<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\InicioSesionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SesionAutenticadaController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('autenticacion.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(InicioSesionRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
  
        
        $request->user()->update([
            'ultimo_acceso' => now(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
