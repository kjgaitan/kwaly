<?php

namespace App\Helpers;

class FormatoHelper
{
    public static function moneda($cantidad): string
    {
        return number_format((float) $cantidad, 2, ',', '.') . ' €';
    }

    public static function porcentaje($valor): string
    {
        return number_format((float) $valor, 2, ',', '.') . ' %';
    }

    public static function mesNombre(int $mes): string
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses[$mes] ?? 'Mes no válido';
    }
}