<?php

namespace App\Services;

use App\Models\PresupuestoMensual;
use App\Models\Transaccion;
use Illuminate\Support\Collection;

class PresupuestoService
{
    /**
     * Obtiene todos los datos necesarios para la vista principal de presupuestos.
     */
    public function obtenerDatosIndex(int $usuarioId): array
    {
        $presupuestos = PresupuestoMensual::with(['detalles.categoria'])
            ->where('id_usuario', $usuarioId)
            ->orderByDesc('anio')
            ->orderByDesc('mes')
            ->get();

        $presupuestos->each(function ($presupuesto) use ($usuarioId) {
            $presupuesto->ingreso_real = Transaccion::where('id_usuario', $usuarioId)
                ->where('tipo_movimiento', 'ingreso')
                ->whereYear('fecha_transaccion', $presupuesto->anio)
                ->whereMonth('fecha_transaccion', $presupuesto->mes)
                ->sum('monto');
        });

        $presupuestoActual = $presupuestos->first();

        $datosBase = $this->obtenerValoresPorDefecto();

        if (!$presupuestoActual) {
            return array_merge([
                'presupuestos' => $presupuestos,
                'presupuestoActual' => null,
            ], $datosBase);
        }

        $detalles = $presupuestoActual->detalles;

        $montoNecesidades = $this->sumarPorTipo($detalles, 'necesidad', 'limite_monto');
        $montoDeseos = $this->sumarPorTipo($detalles, 'deseo', 'limite_monto');
        $montoAhorro = $this->sumarPorTipo($detalles, 'ahorro', 'limite_monto');

        $gastadoNecesidades = $this->sumarPorTipo($detalles, 'necesidad', 'monto_gastado');
        $gastadoDeseos = $this->sumarPorTipo($detalles, 'deseo', 'monto_gastado');
        $gastadoAhorro = $this->sumarPorTipo($detalles, 'ahorro', 'monto_gastado');

        return [
            'presupuestos' => $presupuestos,
            'presupuestoActual' => $presupuestoActual,
            'ingresoMensual' => (float) $presupuestoActual->ingreso_estimado,
            'ingresoReal' => (float) ($presupuestoActual->ingreso_real ?? 0),
            'porcNecesidades' => (float) $presupuestoActual->porcentaje_necesidades,
            'porcDeseos' => (float) $presupuestoActual->porcentaje_deseos,
            'porcAhorro' => (float) $presupuestoActual->porcentaje_ahorro,
            'montoNecesidades' => $montoNecesidades,
            'montoDeseos' => $montoDeseos,
            'montoAhorro' => $montoAhorro,
            'gastadoNecesidades' => $gastadoNecesidades,
            'gastadoDeseos' => $gastadoDeseos,
            'gastadoAhorro' => $gastadoAhorro,
            'dispNecesidades' => $montoNecesidades - $gastadoNecesidades,
            'dispDeseos' => $montoDeseos - $gastadoDeseos,
            'dispAhorro' => $montoAhorro - $gastadoAhorro,
            'porcentajeUsoNecesidades' => $this->calcularPorcentajeUso($gastadoNecesidades, $montoNecesidades),
            'porcentajeUsoDeseos' => $this->calcularPorcentajeUso($gastadoDeseos, $montoDeseos),
            'porcentajeUsoAhorro' => $this->calcularPorcentajeUso($gastadoAhorro, $montoAhorro),
            'detalles' => $detalles,
        ];
    }

    /**
     * Devuelve los valores iniciales por defecto.
     */
    private function obtenerValoresPorDefecto(): array
    {
        return [
            'ingresoMensual' => 0,
            'ingresoReal' => 0,
            'porcNecesidades' => 50,
            'porcDeseos' => 30,
            'porcAhorro' => 20,
            'montoNecesidades' => 0,
            'montoDeseos' => 0,
            'montoAhorro' => 0,
            'gastadoNecesidades' => 0,
            'gastadoDeseos' => 0,
            'gastadoAhorro' => 0,
            'dispNecesidades' => 0,
            'dispDeseos' => 0,
            'dispAhorro' => 0,
            'porcentajeUsoNecesidades' => 0,
            'porcentajeUsoDeseos' => 0,
            'porcentajeUsoAhorro' => 0,
            'detalles' => collect(),
        ];
    }

    /**
     * Suma un campo por tipo de categoría.
     */
    private function sumarPorTipo(Collection $detalles, string $tipoCategoria, string $campo): float
    {
        return (float) $detalles
            ->sum($campo);
    }

    /**
     * Calcula el porcentaje de uso de un monto respecto a su límite.
     */
    private function calcularPorcentajeUso(float $gastado, float $monto): float
    {
        if ($monto <= 0) {
            return 0;
        }

        return min(($gastado / $monto) * 100, 100);
    }
}