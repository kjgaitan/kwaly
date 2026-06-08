<?php

namespace App\Http\Requests\PresupuestoDetalleCategoria;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PresupuestoMensual;
use App\Models\PresupuestoDetalleCategoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePresupuestoDetalleCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_presupuesto' => [
                'required',
                Rule::exists('presupuestos_mensuales', 'id_presupuesto')->where('id_usuario', Auth::id()),
            ],
            'id_categoria' => [
                'required',
                Rule::exists('categorias', 'id_categoria')->where('id_usuario', Auth::id()),
            ],
            'tipo_presupuesto' => 'required|in:necesidades,deseos,ahorro',
            'limite_monto' => 'required|numeric|min:0',
            'monto_gastado' => 'nullable|numeric|min:0',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $presupuestoId = $this->input('id_presupuesto') ?? $this->route('presupuesto');
            $tipoPresupuesto = $this->input('tipo_presupuesto');

            $presupuesto = PresupuestoMensual::find($presupuestoId);

            if (!$presupuesto) {
                $validator->errors()->add('id_presupuesto', 'Presupuesto no encontrado.');
                return;
            }

            if (!in_array($tipoPresupuesto, ['necesidades', 'deseos', 'ahorro'], true)) {
                $validator->errors()->add('tipo_presupuesto', 'Debes seleccionar un tipo de presupuesto válido.');
                return;
            }

            $porcentajeTipo = $presupuesto->{'porcentaje_' . $tipoPresupuesto};
            $limiteTipo = ($porcentajeTipo / 100) * (float) $presupuesto->ingreso_estimado;
            $sumaExistente = PresupuestoDetalleCategoria::where('id_presupuesto', $presupuesto->id_presupuesto)
                ->where('tipo_presupuesto', $tipoPresupuesto)
                ->sum('limite_monto');

            $nuevo = (float) $this->input('limite_monto');

            if (($sumaExistente + $nuevo) > $limiteTipo) {
                $validator->errors()->add('limite_monto', 'La suma de los límites de ' . $tipoPresupuesto . ' no puede superar ' . number_format($limiteTipo, 2, ',', '.') . ' € (' . number_format($porcentajeTipo, 0) . '% del presupuesto).');
            }

            $sumaTotalExistente = PresupuestoDetalleCategoria::where('id_presupuesto', $presupuesto->id_presupuesto)
                ->sum('limite_monto');

            if (($sumaTotalExistente + $nuevo) > (float) $presupuesto->ingreso_estimado) {
                $validator->errors()->add('limite_monto', 'La suma de los límites no puede superar el ingreso del presupuesto (' . number_format((float)$presupuesto->ingreso_estimado, 2, ',', '.') . ' €).');
            }
        });
    }

    public function messages(): array
    {
        return [
            'id_categoria.required' => 'Debes seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no es válida.',
            'id_presupuesto.required' => 'Debes seleccionar un presupuesto.',
            'id_presupuesto.exists' => 'El presupuesto seleccionado no es válido.',
            'tipo_presupuesto.required' => 'Debes seleccionar un tipo de presupuesto.',
            'tipo_presupuesto.in' => 'El tipo de presupuesto seleccionado no es válido.',
            'limite_monto.required' => 'Debes introducir el límite de monto.',
            'limite_monto.numeric' => 'El límite de monto debe ser numérico.',
            'limite_monto.min' => 'El límite de monto no puede ser negativo.',
        ];
    }
}
