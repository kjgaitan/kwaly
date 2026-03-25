<?php

namespace App\Http\Requests\Reporte;

use Illuminate\Foundation\Http\FormRequest;

class FiltrarReporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio' => 'nullable|integer|min:2000|max:2100',
            'mes' => 'nullable|integer|min:1|max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'El año no es válido.',
            'anio.max' => 'El año no es válido.',
            'mes.integer' => 'El mes debe ser un número entero.',
            'mes.min' => 'El mes debe estar entre 1 y 12.',
            'mes.max' => 'El mes debe estar entre 1 y 12.',
        ];
    }
}