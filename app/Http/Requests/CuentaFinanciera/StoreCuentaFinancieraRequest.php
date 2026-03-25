<?php

namespace App\Http\Requests\CuentaFinanciera;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuentaFinancieraRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear una cuenta financiera.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'tipo_cuenta' => 'nullable|in:efectivo,banco,tarjeta,ahorro,otro',
            'saldo_actual' => 'nullable|numeric|min:0',
            'moneda' => 'nullable|string|max:3',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la cuenta es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'tipo_cuenta.in' => 'El tipo de cuenta no es válido.',
            'saldo_actual.numeric' => 'El saldo actual debe ser un número válido.',
            'saldo_actual.min' => 'El saldo actual no puede ser negativo.',
            'moneda.max' => 'La moneda no puede superar los 3 caracteres.',
        ];
    }
}