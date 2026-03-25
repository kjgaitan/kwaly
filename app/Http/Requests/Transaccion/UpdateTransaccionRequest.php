<?php

namespace App\Http\Requests\Transaccion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cuenta' => 'nullable|exists:cuentas_financieras,id_cuenta',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'tipo_movimiento' => 'required|in:ingreso,gasto',
            'titulo' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_transaccion' => 'required|date',
            'metodo_pago' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id_cuenta.exists' => 'La cuenta seleccionada no es válida.',
            'id_categoria.exists' => 'La categoría seleccionada no es válida.',
            'tipo_movimiento.required' => 'El tipo de movimiento es obligatorio.',
            'tipo_movimiento.in' => 'El tipo de movimiento debe ser ingreso o gasto.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número válido.',
            'monto.min' => 'El monto no puede ser negativo.',
            'fecha_transaccion.required' => 'La fecha de la transacción es obligatoria.',
            'fecha_transaccion.date' => 'La fecha de la transacción no es válida.',
            'metodo_pago.max' => 'El método de pago no puede superar los 50 caracteres.',
        ];
    }
}