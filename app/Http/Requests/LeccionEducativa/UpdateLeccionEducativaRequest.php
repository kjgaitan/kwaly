<?php

namespace App\Http\Requests\LeccionEducativa;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeccionEducativaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'contenido' => ['required', 'string'],
            'duracion_minutos' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',
            'contenido.required' => 'El contenido es obligatorio.',
            'contenido.string' => 'El contenido debe ser texto.',
            'duracion_minutos.required' => 'La duración es obligatoria.',
            'duracion_minutos.integer' => 'La duración debe ser un número entero.',
            'duracion_minutos.min' => 'La duración debe ser mayor que 0.',
        ];
    }
}
