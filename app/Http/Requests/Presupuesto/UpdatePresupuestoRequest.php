<?php

namespace App\Http\Requests\Presupuesto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdatePresupuestoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $ingresoEstimado = $this->input('ingreso_estimado');

        if ($ingresoEstimado !== null && $ingresoEstimado !== '') {
            $ingresoEstimado = str_replace('.', '', $ingresoEstimado);
            $ingresoEstimado = str_replace(',', '.', $ingresoEstimado);
        }

        $this->merge([
            'ingreso_estimado' => $ingresoEstimado,
        ]);
    }

    public function rules(): array
    {
        $idPresupuesto = $this->route('presupuesto') ?? $this->route('id');

        return [
            'anio' => 'required|integer|min:' . date('Y') . '|max:2100',
            'mes' => [
                'required',
                'integer',
                'min:1',
                'max:12',
                Rule::unique('presupuestos_mensuales')->where(function ($query) {
                    return $query->where('id_usuario', auth()->user()->id_usuario)
                        ->where('anio', $this->anio);
                })->ignore($idPresupuesto, 'id_presupuesto'),
            ],
            'ingreso_estimado' => 'nullable|numeric|min:0',
            'porcentaje_necesidades' => 'required|numeric|min:0|max:100',
            'porcentaje_deseos' => 'required|numeric|min:0|max:100',
            'porcentaje_ahorro' => 'required|numeric|min:0|max:100',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (
                $validator->errors()->has('porcentaje_necesidades') ||
                $validator->errors()->has('porcentaje_deseos') ||
                $validator->errors()->has('porcentaje_ahorro')
            ) {
                return;
            }

            $necesidades = (float) ($this->input('porcentaje_necesidades') ?? 50);
            $deseos = (float) ($this->input('porcentaje_deseos') ?? 30);
            $ahorro = (float) ($this->input('porcentaje_ahorro') ?? 20);

            if (
                abs($necesidades - 50) > 0.001 ||
                abs($deseos - 30) > 0.001 ||
                abs($ahorro - 20) > 0.001
            ) {
                $validator->errors()->add(
                    'porcentajes',
                    'El presupuesto debe respetar el sistema 50/30/20: 50% necesidades, 30% deseos y 20% ahorro.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'No se pueden crear presupuestos para años anteriores al actual.',
            'anio.max' => 'El año no es válido.',
            'mes.required' => 'El mes es obligatorio.',
            'mes.integer' => 'El mes debe ser un número entero.',
            'mes.min' => 'El mes debe estar entre 1 y 12.',
            'mes.max' => 'El mes debe estar entre 1 y 12.',
            'mes.unique' => 'Ya existe un presupuesto para ese mes y año.',
            'ingreso_estimado.numeric' => 'El ingreso estimado debe ser un número válido.',
            'ingreso_estimado.min' => 'El ingreso estimado no puede ser negativo.',
            'porcentaje_necesidades.required' => 'El porcentaje de necesidades es obligatorio.',
            'porcentaje_necesidades.numeric' => 'El porcentaje de necesidades debe ser numérico.',
            'porcentaje_necesidades.min' => 'El porcentaje de necesidades no puede ser negativo.',
            'porcentaje_necesidades.max' => 'El porcentaje de necesidades no puede superar 100.',
            'porcentaje_deseos.required' => 'El porcentaje de deseos es obligatorio.',
            'porcentaje_deseos.numeric' => 'El porcentaje de deseos debe ser numérico.',
            'porcentaje_deseos.min' => 'El porcentaje de deseos no puede ser negativo.',
            'porcentaje_deseos.max' => 'El porcentaje de deseos no puede superar 100.',
            'porcentaje_ahorro.required' => 'El porcentaje de ahorro es obligatorio.',
            'porcentaje_ahorro.numeric' => 'El porcentaje de ahorro debe ser numérico.',
            'porcentaje_ahorro.min' => 'El porcentaje de ahorro no puede ser negativo.',
            'porcentaje_ahorro.max' => 'El porcentaje de ahorro no puede superar 100.',
        ];
    }
}
