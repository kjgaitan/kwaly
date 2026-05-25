<?php

namespace App\Http\Requests\Compartido;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGastoCompartidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_grupo' => ['required', 'integer', 'exists:grupos_compartidos,id_grupo'],
            'id_usuario_pagador' => [
                'required',
                'integer',
                'exists:usuarios,id_usuario',
                Rule::exists('grupo_miembros', 'id_usuario')
                    ->where('id_grupo', $this->input('id_grupo')),
            ],
            'titulo' => ['required', 'string', 'max:150'],
            'categoria' => ['nullable', 'string', 'max:50'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'monto_total' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'fecha_gasto' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_grupo.required' => 'El grupo es obligatorio.',
            'id_grupo.exists' => 'El grupo seleccionado no existe.',
            'id_usuario_pagador.required' => 'Debes seleccionar quien pago el gasto.',
            'id_usuario_pagador.exists' => 'El usuario seleccionado no pertenece a esta cuenta compartida.',
            'titulo.required' => 'El titulo del gasto es obligatorio.',
            'titulo.max' => 'El titulo del gasto no puede superar los 150 caracteres.',
            'categoria.max' => 'La categoria no puede superar los 50 caracteres.',
            'descripcion.max' => 'La descripcion no puede superar los 255 caracteres.',
            'monto_total.required' => 'El monto total es obligatorio.',
            'monto_total.numeric' => 'El monto total debe ser un numero valido.',
            'monto_total.min' => 'El monto total debe ser mayor que cero.',
            'monto_total.max' => 'El monto total no puede superar 999999.99.',
            'fecha_gasto.required' => 'La fecha del gasto es obligatoria.',
            'fecha_gasto.date' => 'Debes introducir una fecha valida.',
        ];
    }
}
