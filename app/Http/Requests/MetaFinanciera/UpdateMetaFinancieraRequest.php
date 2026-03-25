<?php

namespace App\Http\Requests\MetaFinanciera;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMetaFinancieraRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar una meta financiera.
     */
    public function rules(): array
    {
        return [
            'nombre_meta' => 'required|string|max:150',
            'monto_objetivo' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre_meta.required' => 'El nombre de la meta es obligatorio.',
            'nombre_meta.max' => 'El nombre de la meta no puede superar los 150 caracteres.',
            'monto_objetivo.required' => 'El monto objetivo es obligatorio.',
            'monto_objetivo.numeric' => 'El monto objetivo debe ser un número válido.',
            'monto_objetivo.min' => 'El monto objetivo no puede ser negativo.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',
            'fecha_fin.date' => 'La fecha de fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
        ];
    }
}