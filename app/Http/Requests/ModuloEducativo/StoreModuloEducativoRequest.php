<?php

namespace App\Http\Requests\ModuloEducativo;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuloEducativoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'nivel' => ['required', 'in:basico,intermedio,avanzado'],
            'duracion_minutos' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',

            'descripcion.required' => 'La descripción es obligatoria.',

            'nivel.required' => 'El nivel es obligatorio.',
            'nivel.in' => 'El nivel seleccionado no es válido.',

            'duracion_minutos.required' => 'La duración es obligatoria.',
            'duracion_minutos.integer' => 'La duración debe ser un número entero.',
            'duracion_minutos.min' => 'La duración debe ser mayor que 0.',
        ];
    }
}