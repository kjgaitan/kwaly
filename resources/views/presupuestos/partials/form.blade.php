<form action="{{ $action }}" method="POST" class="space-y-6" novalidate>
    @csrf

    @if($method !== 'POST')
    @method($method)
    @endif

    <!--  ALERTA ARRIBA -->
    <div
        class="flex items-center gap-3 rounded-xl border border-[#4a3f1f] bg-[#2a2415] px-4 py-3 text-sm text-yellow-200">
        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-[#3a3218]">
            <i class="bi bi-exclamation-circle text-yellow-400 text-sm"></i>
        </div>
        <p class="leading-tight">
            Para guardar, el presupuesto debe ser 50% necesidades, 30% deseos y 20% ahorro.
        </p>
    </div>

    <x-input-error :messages="$errors->get('porcentajes')" />


    <div id="budget-percent-warning"
        class="hidden rounded-xl border border-yellow-500/30 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
        La distribucion no es correcta. Necesidades debe ser 50%, deseos 30% y ahorro 20%.
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Año -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Año</label>
            <input type="number" name="anio" value="{{ old('anio', isset($presupuesto) ? $presupuesto->anio : '') }}"
                placeholder="2026"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">

            <x-input-error :messages="$errors->get('anio')" />

        </div>

        <!-- Mes -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Mes</label>
            <select name="mes"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">
                <option value="" disabled
                    {{ old('mes', isset($presupuesto) ? $presupuesto->mes : '') == '' ? 'selected' : '' }}>
                    Seleccione
                </option>

                @php
                $meses = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
                ];
                @endphp

                @foreach($meses as $numero => $nombre)
                <option value="{{ $numero }}"
                    {{ old('mes', isset($presupuesto) ? $presupuesto->mes : '') == $numero ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('mes')" />

        </div>

        <!-- Ingreso estimado -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Ingreso estimado</label>

            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">€</span>

                <input type="text" name="ingreso_estimado" id="ingreso_estimado"
                    value="{{ old('ingreso_estimado', isset($presupuesto) ? number_format((float)$presupuesto->ingreso_estimado, 2, ',', '.') : '') }}"
                    placeholder="3.500,00" inputmode="decimal"
                    class="w-full pl-8 rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">
            </div>

            <x-input-error :messages="$errors->get('ingreso_estimado')" />

        </div>

        <!-- Porcentaje necesidades -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Porcentaje necesidades</label>
            <input type="number" step="0.01" name="porcentaje_necesidades"
                value="{{ old('porcentaje_necesidades', isset($presupuesto) ? $presupuesto->porcentaje_necesidades : 50) }}"
                placeholder="50"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">

            <x-input-error :messages="$errors->get('porcentaje_necesidades')" />

        </div>

        <!-- Porcentaje deseos -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Porcentaje deseos</label>
            <input type="number" step="0.01" name="porcentaje_deseos"
                value="{{ old('porcentaje_deseos', isset($presupuesto) ? $presupuesto->porcentaje_deseos : 30) }}"
                placeholder="30"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">

            <x-input-error :messages="$errors->get('porcentaje_deseos')" />

        </div>

        <!-- Porcentaje ahorro -->
        <div>
            <label class="block text-sm font-medium text-white mb-2">Porcentaje ahorro</label>
            <input type="number" step="0.01" name="porcentaje_ahorro"
                value="{{ old('porcentaje_ahorro', isset($presupuesto) ? $presupuesto->porcentaje_ahorro : 20) }}"
                placeholder="20"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">

            <x-input-error :messages="$errors->get('porcentaje_ahorro')" />

        </div>

    </div>

    <div class="mt-8 flex justify-end gap-3 border-t border-[#26352d] pt-6 pr-2 pb-2">
        <a href="{{ route('presupuestos.index') }}"
            class="px-5 py-2 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-700">
            Cancelar
        </a>

        <button type="submit" id="budget-submit-button"
            class="px-6 py-2 rounded-lg bg-[#72f59a] hover:bg-[#5fe085] text-black font-semibold transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
            {{ $submitText }}
        </button>
    </div>
</form>

<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('ingreso_estimado');
    const warning = document.getElementById('budget-percent-warning');
    const submitButton = document.getElementById('budget-submit-button');
    const necesidades = document.querySelector('[name="porcentaje_necesidades"]');
    const deseos = document.querySelector('[name="porcentaje_deseos"]');
    const ahorro = document.querySelector('[name="porcentaje_ahorro"]');

    function numeroCampo(campo) {
        if (!campo || campo.value === '') {
            return null;
        }

        const valor = Number.parseFloat(campo.value);

        return Number.isNaN(valor) ? null : valor;
    }

    function actualizarAvisoPorcentajes() {
        if (!warning) return;

        const distribucionCorrecta =
            numeroCampo(necesidades) === 50 &&
            numeroCampo(deseos) === 30 &&
            numeroCampo(ahorro) === 20;

        warning.classList.toggle('hidden', distribucionCorrecta);

        if (submitButton) {
            submitButton.disabled = !distribucionCorrecta;
        }
    }

    [necesidades, deseos, ahorro].forEach(function(campo) {
        if (campo) {
            campo.addEventListener('input', actualizarAvisoPorcentajes);
        }
    });

    actualizarAvisoPorcentajes();

    if (!input) return;

    input.addEventListener('input', function(e) {
        let valor = e.target.value;

        valor = valor.replace(/\./g, '');
        valor = valor.replace(',', '');
        valor = valor.replace(/\D/g, '');

        if (valor === '') {
            e.target.value = '';
            return;
        }

        let numero = parseFloat(valor) / 100;

        if (!isNaN(numero)) {
            e.target.value = numero.toLocaleString('es-ES', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    });
});
</script>