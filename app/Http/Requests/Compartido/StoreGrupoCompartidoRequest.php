<?php

namespace App\Http\Requests\Compartido;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoCompartidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_grupo' => ['required', 'string', 'max:100'],
            'descripcion' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_grupo.required' => 'El nombre del grupo es obligatorio.',
            'nombre_grupo.max' => 'El nombre del grupo no puede superar los 100 caracteres.',
            'descripcion.required' => 'La descripción del grupo es obligatoria.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_grupo' => 'nombre del grupo',
            'descripcion' => 'descripción',
        ];
    }
}