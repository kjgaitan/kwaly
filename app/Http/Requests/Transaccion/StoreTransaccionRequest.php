<?php
namespace App\Http\Requests\Transaccion;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cuenta' => 'nullable|exists:cuentas_financieras,id_cuenta',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'tipo_movimiento' => 'required|in:ingreso,gasto',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'fecha_transaccion' => 'required|date',
            'metodo_pago' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id_cuenta.exists' => 'La cuenta seleccionada no es válida.',
            'id_categoria.exists' => 'La categoría seleccionada no es válida.',
            'id_categoria.required' => 'La categoría es obligatoria, si no tienes ningúna en el selector crea una en el módulo de configuración.',
            'tipo_movimiento.required' => 'El tipo de movimiento es obligatorio.',
            'tipo_movimiento.in' => 'El tipo de movimiento debe ser ingreso o gasto.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',
            'titulo.required' => 'El título es obligatorio.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número válido.',
            'monto.min' => 'El monto no puede ser negativo.',
            'fecha_transaccion.required' => 'La fecha de la transacción es obligatoria.',
            'fecha_transaccion.date' => 'La fecha de la transacción no es válida.',
            'metodo_pago.max' => 'El método de pago no puede superar los 50 caracteres.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
        ];
    }
}