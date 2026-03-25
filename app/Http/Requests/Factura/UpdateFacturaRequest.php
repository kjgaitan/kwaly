<?php

namespace App\Http\Requests\Factura;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacturaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar una factura.
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date',
            'estado' => 'nullable|string|max:50',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título de la factura es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número válido.',
            'monto.min' => 'El monto no puede ser negativo.',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
            'fecha_emision.date' => 'La fecha de emisión no es válida.',
            'estado.max' => 'El estado no puede superar los 50 caracteres.',
        ];
    }
}