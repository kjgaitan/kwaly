<?php

namespace App\Http\Requests\ModuloEducativo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModuloEducativoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'nivel' => ['required', 'in:basico,intermedio,avanzado'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',

            'nivel.required' => 'El nivel es obligatorio.',
            'nivel.in' => 'El nivel seleccionado no es válido.',

        ];
    }
}
