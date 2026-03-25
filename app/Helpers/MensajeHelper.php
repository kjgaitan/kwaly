<?php

namespace App\Helpers;

class MensajeHelper
{
    public static function creado(string $elemento): string
    {
        return $elemento . ' creado correctamente.';
    }

    public static function actualizado(string $elemento): string
    {
        return $elemento . ' actualizado correctamente.';
    }

    public static function eliminado(string $elemento): string
    {
        return $elemento . ' eliminado correctamente.';
    }

    public static function error(string $detalle = 'Ha ocurrido un error inesperado.'): string
    {
        return $detalle;
    }

    public static function noEncontrado(string $elemento): string
    {
        return $elemento . ' no encontrado.';
    }
}