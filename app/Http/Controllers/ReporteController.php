<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reporte\ReportesIndexRequest;
use App\Services\ReporteService;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function __construct(
        protected ReporteService $reporteService
    ) {
    }

    public function index(ReportesIndexRequest $request)
    {
        $idUsuario = Auth::user()->id_usuario;

        $anio = (int) ($request->input('anio') ?: now()->year);
        $mes = (int) ($request->input('mes') ?: now()->month);

        $data = $this->reporteService->obtenerDatosReportes($idUsuario, $anio, $mes);

        return view('reportes.index', $data);
    }
}