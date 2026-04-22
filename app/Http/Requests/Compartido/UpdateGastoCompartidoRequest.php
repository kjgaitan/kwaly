<?php

namespace App\Http\Requests\Compartido;

use Illuminate\Foundation\Http\FormRequest;

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
            'titulo' => ['required', 'string', 'max:150'],
            'monto_total' => ['required', 'numeric', 'min:0.01'],
            'fecha_gasto' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_grupo.required' => 'El grupo es obligatorio.',
            'id_grupo.exists' => 'El grupo seleccionado no existe.',

            'titulo.required' => 'El título del gasto es obligatorio.',
            'titulo.max' => 'El título del gasto no puede superar los 150 caracteres.',

            'monto_total.required' => 'El monto total es obligatorio.',
            'monto_total.numeric' => 'El monto total debe ser un número válido.',
            'monto_total.min' => 'El monto total debe ser mayor que cero.',

            'fecha_gasto.required' => 'La fecha del gasto es obligatoria.',
            'fecha_gasto.date' => 'Debes introducir una fecha válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_grupo' => 'grupo',
            'titulo' => 'título',
            'monto_total' => 'monto total',
            'fecha_gasto' => 'fecha del gasto',
        ];
    }
}