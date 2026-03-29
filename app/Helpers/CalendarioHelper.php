<?php

namespace App\Helpers;

class CalendarioHelper
{
    public static function claseEvento(string $tipo): string
    {
        return match ($tipo) {
            'ingreso' => 'calendar-event calendar-event--income',
            'gasto' => 'calendar-event calendar-event--expense',
            default => 'calendar-event calendar-event--reminder',
        };
    }

    public static function diasSemana(): array
    {
        return ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
    }

    public static function obtenerConsejoFinanciero(float $balancePrevisto, bool $hayDatos): string
    {
        if (!$hayDatos) {
            return 'No hay datos suficientes para generar una previsión financiera. Comienza registrando tus ingresos, gastos o facturas.';
        }

        if ($balancePrevisto > 0) {
            return 'Este mes vas por buen camino. Aprovecha el saldo positivo para reforzar tu ahorro o adelantar pagos importantes.';
        }

        if ($balancePrevisto < 0) {
            return 'Este mes tus pagos superan a tus ingresos previstos. Revisa tus gastos no esenciales y prioriza los compromisos más urgentes.';
        }

        return 'Tu balance previsto está equilibrado. Mantén controlados tus movimientos para no salirte del presupuesto.';
    }
}