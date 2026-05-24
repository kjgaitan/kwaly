<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    <div>
        <label for="proveedor" class="mb-2 block text-sm font-medium text-gray-300">Proveedor</label>
        <input type="text" id="proveedor" name="proveedor" value="{{ old('proveedor', $factura->proveedor ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Endesa">
        <x-input-error :messages="$errors->get('proveedor')" />

    </div>

    <div>
        <label for="concepto" class="mb-2 block text-sm font-medium text-gray-300">Concepto</label>
        <input type="text" id="concepto" name="concepto" value="{{ old('concepto', $factura->concepto ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Electricidad">
        <x-input-error :messages="$errors->get('concepto')" />

    </div>

    <div class="md:col-span-2">
        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-300">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Añade una descripción">{{ old('descripcion', $factura->descripcion ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" />

    </div>

    <div>
        <label for="monto_total" class="mb-2 block text-sm font-medium text-gray-300">Monto total (€)</label>
        <input type="number" step="0.01" min="0" id="monto_total" name="monto_total"
            value="{{ old('monto_total', $factura->monto_total ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="0.00">
        <x-input-error :messages="$errors->get('monto_total')" />

    </div>

    <div>
        <label for="fecha_vencimiento" class="mb-2 block text-sm font-medium text-gray-300">Fecha de vencimiento</label>
        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"
            value="{{ old('fecha_vencimiento', isset($factura) && $factura->fecha_vencimiento ? \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('Y-m-d') : '') }}"
            class="facturas-date">
        <x-input-error :messages="$errors->get('fecha_vencimiento')" />

    </div>

    <div>
        <label for="estado" class="mb-2 block text-sm font-medium text-gray-300">Estado</label>
        <select id="estado" name="estado"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white focus:border-[#72f59a] focus:outline-none"
            required>
            <option value="" disabled {{ old('estado', $factura->estado ?? '') === '' ? 'selected' : '' }}>
                Seleccione
            </option>
            <option value="pendiente" {{ old('estado', $factura->estado ?? '') === 'pendiente' ? 'selected' : '' }}>
                Pendiente
            </option>
            <option value="pagada" {{ old('estado', $factura->estado ?? '') === 'pagada' ? 'selected' : '' }}>
                Pagada
            </option>
            <option value="vencida" {{ old('estado', $factura->estado ?? '') === 'vencida' ? 'selected' : '' }}>
                Vencida
            </option>
        </select>
        <x-input-error :messages="$errors->get('estado')" />

    </div>

    <div>
        <label for="frecuencia" class="mb-2 block text-sm font-medium text-gray-300">Frecuencia</label>
        <select id="frecuencia" name="frecuencia"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white focus:border-[#72f59a] focus:outline-none"
            required>
            <option value="" disabled {{ old('frecuencia', $factura->frecuencia ?? '') === '' ? 'selected' : '' }}>
                Seleccione
            </option>
            <option value="unica" {{ old('frecuencia', $factura->frecuencia ?? '') === 'unica' ? 'selected' : '' }}>
                Única
            </option>
            <option value="mensual" {{ old('frecuencia', $factura->frecuencia ?? '') === 'mensual' ? 'selected' : '' }}>
                Mensual
            </option>
            <option value="anual" {{ old('frecuencia', $factura->frecuencia ?? '') === 'anual' ? 'selected' : '' }}>
                Anual
            </option>
        </select>
        <x-input-error :messages="$errors->get('frecuencia')" />

    </div>
    <div class="md:col-span-2 mt-8 flex items-center justify-end gap-3 pt-6 pr-2 pb-2">
        <a href="{{ route('facturas.index') }}"
            class="inline-flex items-center rounded-xl border border-[#314238] px-5 py-3 text-sm font-semibold text-gray-300 transition hover:border-[#72f59a] hover:text-white">
            Cancelar
        </a>

        <button type="submit"
            class="inline-flex items-center rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-[#0d1510] transition hover:brightness-110">
            {{ $boton }}
        </button>

    </div>