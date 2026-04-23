<?php

namespace App\Http\Requests\Configuracion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para validar la actualización de moneda.
 */
class UpdateMonedaRequest extends FormRequest
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
            'moneda_preferida' => ['required', 'string', 'size:3'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'moneda_preferida.required' => 'La moneda principal es obligatoria.',
            'moneda_preferida.size' => 'La moneda debe tener exactamente 3 caracteres.',
        ];
    }
}