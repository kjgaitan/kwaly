<?php

namespace App\Helpers;

class ConsejoFinancieroHelper
{
    public static function generarConsejo(float $ingresos, float $gastos, float $balance): string
    {
        if ($ingresos == 0 && $gastos == 0) {
            return 'Aún no hay movimientos registrados este mes. Empieza anotando tus ingresos y gastos para obtener una visión clara de tu situación financiera.';
        }

        if ($balance < 0) {
            return 'Tus gastos previstos superan tus ingresos. Revisa los pagos próximos y prioriza los gastos esenciales para evitar un desequilibrio financiero.';
        }

        if ($gastos > 0 && $ingresos > 0 && $gastos >= ($ingresos * 0.8)) {
            return 'Tus gastos representan una parte alta de tus ingresos este mes. Intenta reservar una pequeña cantidad para ahorro antes de realizar gastos no esenciales.';
        }

        return 'Vas bien este mes. Mantener un margen positivo entre ingresos y gastos te ayudará a construir ahorro y a afrontar imprevistos con más tranquilidad.';
    }
}