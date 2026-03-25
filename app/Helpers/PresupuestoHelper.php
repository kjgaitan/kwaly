<?php

namespace App\Helpers;

class PresupuestoHelper
{
    public static function meses(): array
    {
        return [
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
    }

    public static function nombreMes(?int $mes): string
    {
        $meses = self::meses();

        return $meses[$mes] ?? 'Mes desconocido';
    }

    public static function colorUsoSobre(float $uso): string
    {
        if ($uso >= 95) {
            return 'bg-red-400';
        }

        if ($uso >= 80) {
            return 'bg-yellow-400';
        }

        return 'bg-[#72f59a]';
    }

    public static function colorDisponible(float $disponible): string
    {
        return $disponible < 0 ? 'text-red-400' : 'text-[#72f59a]';
    }

    public static function colorBarraAhorro(float $porcentajeUsoAhorro): string
    {
        return $porcentajeUsoAhorro >= 100 ? 'bg-yellow-400' : 'bg-[#72f59a]';
    }
}