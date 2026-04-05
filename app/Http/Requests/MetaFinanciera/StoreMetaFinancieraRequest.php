<?php

namespace App\Http\Requests\MetaFinanciera;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetaFinancieraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'monto_objetivo' => ['required', 'numeric', 'min:0.01'],
            'monto_actual' => ['nullable', 'numeric', 'min:0'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_limite' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'prioridad' => ['required', 'in:baja,media,alta'],
            'estado' => ['required', 'in:activa,completada,pausada'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título de la meta es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',

            'monto_objetivo.required' => 'El monto objetivo es obligatorio.',
            'monto_objetivo.numeric' => 'El monto objetivo debe ser un número válido.',
            'monto_objetivo.min' => 'El monto objetivo debe ser mayor que 0.',

            'monto_actual.numeric' => 'El monto actual debe ser un número válido.',
            'monto_actual.min' => 'El monto actual no puede ser negativo.',

            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',

            'fecha_limite.date' => 'La fecha límite no es válida.',
            'fecha_limite.after_or_equal' => 'La fecha límite no puede ser anterior a la fecha de inicio.',

            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in' => 'La prioridad seleccionada no es válida.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }
}