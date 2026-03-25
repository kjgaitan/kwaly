<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear una categoría.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'tipo_categoria' => 'required|in:ingreso,gasto',
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
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'tipo_categoria.required' => 'El tipo de categoría es obligatorio.',
            'tipo_categoria.in' => 'El tipo de categoría debe ser ingreso o gasto.',
            'icono.max' => 'El icono no puede superar los 100 caracteres.',
            'color_hex.max' => 'El color no puede superar los 7 caracteres.',
        ];
    }
}