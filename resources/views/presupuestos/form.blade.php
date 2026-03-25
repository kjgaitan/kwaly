@php
    use App\Helpers\PresupuestoHelper;

    $meses = PresupuestoHelper::meses();
    $esEdicion = isset($presupuesto);
@endphp

@if ($errors->any())
    <div class="budget-alert-error">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm text-gray-300">Año</label>
            <input
                type="number"
                name="anio"
                value="{{ old('anio', $presupuesto->anio ?? '') }}"
                class="budget-input"
                placeholder="2026"
            >
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Mes</label>
            <select name="mes" class="budget-input">
                <option value="">Selecciona un mes</option>
                @foreach($meses as $numero => $nombre)
                    <option value="{{ $numero }}" {{ (string) old('mes', $presupuesto->mes ?? '') === (string) $numero ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Ingreso estimado</label>
            <input
                type="number"
                step="0.01"
                name="ingreso_estimado"
                value="{{ old('ingreso_estimado', $presupuesto->ingreso_estimado ?? '') }}"
                class="budget-input"
                placeholder="3500.00"
            >
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Porcentaje necesidades</label>
            <input
                type="number"
                step="0.01"
                name="porcentaje_necesidades"
                value="{{ old('porcentaje_necesidades', $presupuesto->porcentaje_necesidades ?? 50) }}"
                class="budget-input"
            >
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Porcentaje deseos</label>
            <input
                type="number"
                step="0.01"
                name="porcentaje_deseos"
                value="{{ old('porcentaje_deseos', $presupuesto->porcentaje_deseos ?? 30) }}"
                class="budget-input"
            >
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Porcentaje ahorro</label>
            <input
                type="number"
                step="0.01"
                name="porcentaje_ahorro"
                value="{{ old('porcentaje_ahorro', $presupuesto->porcentaje_ahorro ?? 20) }}"
                class="budget-input"
            >
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('presupuestos.index') }}" class="budget-btn-secondary">
            Cancelar
        </a>

        <button type="submit" class="rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
            {{ $submitText }}
        </button>
    </div>
</form>