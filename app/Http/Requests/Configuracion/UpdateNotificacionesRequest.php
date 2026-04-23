<?php

namespace App\Http\Requests\Configuracion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para validar la configuración de notificaciones y seguridad.
 */
class UpdateNotificacionesRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [
            'notificacion_email' => ['nullable', 'boolean'],
            'notificacion_push' => ['nullable', 'boolean'],
            'alerta_presupuesto' => ['nullable', 'boolean'],
            'recordatorio_pagos' => ['nullable', 'boolean'],
            'autenticacion_2fa' => ['nullable', 'boolean'],
        ];
    }
}