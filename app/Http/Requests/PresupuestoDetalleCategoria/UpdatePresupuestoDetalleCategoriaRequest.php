<?php

namespace App\Http\Requests\PresupuestoDetalleCategoria;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresupuestoDetalleCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'limite_monto' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'id_categoria.required' => 'Debes seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no es válida.',
            'limite_monto.required' => 'Debes introducir el límite de monto.',
            'limite_monto.numeric' => 'El límite de monto debe ser numérico.',
            'limite_monto.min' => 'El límite de monto no puede ser negativo.',
        ];
    }
}