<?php

namespace App\Http\Requests\Transaccion;

use Illuminate\Foundation\Http\FormRequest;

class FiltrarTransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'buscar' => 'nullable|string|max:150',
            'tipo' => 'nullable|in:ingreso,gasto',
        ];
    }

    public function messages(): array
    {
        return [
            'buscar.max' => 'La búsqueda no puede superar los 150 caracteres.',
            'tipo.in' => 'El tipo seleccionado no es válido.',
        ];
    }
}