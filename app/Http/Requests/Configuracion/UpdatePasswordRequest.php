<?php

namespace App\Http\Requests\Configuracion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para validar el cambio de contraseña.
 */
class UpdatePasswordRequest extends FormRequest
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
            'password_actual' => ['required'],
            'password_nueva' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'password_actual.required' => 'La contraseña actual es obligatoria.',
            'password_nueva.required' => 'La nueva contraseña es obligatoria.',
            'password_nueva.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password_nueva.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ];
    }
}