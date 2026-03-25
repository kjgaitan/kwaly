<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfiguracionRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar la configuración.
     */
    public function rules(): array
    {
        return [
            'tema' => 'nullable|string|max:50',
            'notificaciones_email' => 'nullable|boolean',
            'notificaciones_push' => 'nullable|boolean',
            'moneda_preferida' => 'nullable|string|max:3',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'tema.max' => 'El tema no puede superar los 50 caracteres.',
            'notificaciones_email.boolean' => 'El valor de notificaciones por email no es válido.',
            'notificaciones_push.boolean' => 'El valor de notificaciones push no es válido.',
            'moneda_preferida.max' => 'La moneda preferida no puede superar los 3 caracteres.',
        ];
    }
}