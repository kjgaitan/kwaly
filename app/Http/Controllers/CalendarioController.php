<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendario\CalendarioIndexRequest;
use App\Services\CalendarioService;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    public function __construct(
        protected CalendarioService $calendarioService
    ) {
    }

    public function index(CalendarioIndexRequest $request)
    {
        $idUsuario = Auth::user()->id_usuario;
        $mes = $request->validated('mes');

        $data = $this->calendarioService->obtenerDatosVista($idUsuario, $mes);

        return view('calendario.index', $data);
    }
}