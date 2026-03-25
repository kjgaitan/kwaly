<?php

namespace App\Http\Requests\Presupuesto;

use Illuminate\Foundation\Http\FormRequest;

class StorePresupuestoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|min:1|max:12',
            'ingreso_estimado' => 'nullable|numeric|min:0',
            'porcentaje_necesidades' => 'nullable|numeric|min:0|max:100',
            'porcentaje_deseos' => 'nullable|numeric|min:0|max:100',
            'porcentaje_ahorro' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'El año no es válido.',
            'anio.max' => 'El año no es válido.',
            'mes.required' => 'El mes es obligatorio.',
            'mes.integer' => 'El mes debe ser un número entero.',
            'mes.min' => 'El mes debe estar entre 1 y 12.',
            'mes.max' => 'El mes debe estar entre 1 y 12.',
            'ingreso_estimado.numeric' => 'El ingreso estimado debe ser un número válido.',
            'ingreso_estimado.min' => 'El ingreso estimado no puede ser negativo.',
            'porcentaje_necesidades.numeric' => 'El porcentaje de necesidades debe ser numérico.',
            'porcentaje_necesidades.min' => 'El porcentaje de necesidades no puede ser negativo.',
            'porcentaje_necesidades.max' => 'El porcentaje de necesidades no puede superar 100.',
            'porcentaje_deseos.numeric' => 'El porcentaje de deseos debe ser numérico.',
            'porcentaje_deseos.min' => 'El porcentaje de deseos no puede ser negativo.',
            'porcentaje_deseos.max' => 'El porcentaje de deseos no puede superar 100.',
            'porcentaje_ahorro.numeric' => 'El porcentaje de ahorro debe ser numérico.',
            'porcentaje_ahorro.min' => 'El porcentaje de ahorro no puede ser negativo.',
            'porcentaje_ahorro.max' => 'El porcentaje de ahorro no puede superar 100.',
        ];
    }
}