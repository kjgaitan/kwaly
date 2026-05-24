<?php

namespace App\Http\Requests\Factura;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor' => 'required|string|max:150',
            'concepto' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'monto_total' => 'required|numeric|min:0.01|max:999999.99',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,pagada,vencida',
            'frecuencia' => 'required|in:unica,mensual,anual',
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor.required' => 'El proveedor es obligatorio.',
            'proveedor.max' => 'El proveedor no puede superar los 150 caracteres.',

            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.max' => 'El concepto no puede superar los 150 caracteres.',

            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',

            'monto_total.required' => 'El monto total es obligatorio.',
            'monto_total.numeric' => 'El monto total debe ser numérico.',
            'monto_total.min' => 'El monto total debe ser mayor que 0.',
            'monto_total.max' => 'El monto total es demasiado alto.',

            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date' => 'La fecha de vencimiento no es válida.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'frecuencia.required' => 'La frecuencia es obligatoria.',
            'frecuencia.in' => 'La frecuencia seleccionada no es válida.',
        ];
    }
}