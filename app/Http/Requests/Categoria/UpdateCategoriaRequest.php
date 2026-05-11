<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar una categoría.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'icono' => 'nullable|string|max:100',
            'color_hex' => 'nullable|string|max:7',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => __('validation.nombre_required'),
            'nombre.max' => __('validation.nombre_max'),
            'icono.max' => __('validation.icono_max'),
            'color_hex.max' => __('validation.color_hex_max'),
        ];
    }
}