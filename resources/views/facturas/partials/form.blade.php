<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    <div>
        <label for="proveedor" class="mb-2 block text-sm font-medium text-gray-300">Proveedor</label>
        <input
            type="text"
            id="proveedor"
            name="proveedor"
            value="{{ old('proveedor', $factura->proveedor ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Ej. Endesa"
            required
        >
        @error('proveedor')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="concepto" class="mb-2 block text-sm font-medium text-gray-300">Concepto</label>
        <input
            type="text"
            id="concepto"
            name="concepto"
            value="{{ old('concepto', $factura->concepto ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Ej. Electricidad"
            required
        >
        @error('concepto')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-300">Descripción</label>
        <textarea
            id="descripcion"
            name="descripcion"
            rows="4"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="Añade una descripción opcional"
        >{{ old('descripcion', $factura->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="monto_total" class="mb-2 block text-sm font-medium text-gray-300">Monto total (€)</label>
        <input
            type="number"
            step="0.01"
            min="0"
            id="monto_total"
            name="monto_total"
            value="{{ old('monto_total', $factura->monto_total ?? '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white placeholder-gray-500 focus:border-[#72f59a] focus:outline-none"
            placeholder="0.00"
            required
        >
        @error('monto_total')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_vencimiento" class="mb-2 block text-sm font-medium text-gray-300">Fecha de vencimiento</label>
        <input
            type="date"
            id="fecha_vencimiento"
            name="fecha_vencimiento"
            value="{{ old('fecha_vencimiento', isset($factura) && $factura->fecha_vencimiento ? \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('Y-m-d') : '') }}"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white focus:border-[#72f59a] focus:outline-none"
            required
        >
        @error('fecha_vencimiento')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="estado" class="mb-2 block text-sm font-medium text-gray-300">Estado</label>
        <select
            id="estado"
            name="estado"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white focus:border-[#72f59a] focus:outline-none"
        >
            <option value="pendiente" {{ old('estado', $factura->estado ?? 'pendiente') === 'pendiente' ? 'selected' : '' }}>
                Pendiente
            </option>
            <option value="pagado" {{ old('estado', $factura->estado ?? '') === 'pagado' ? 'selected' : '' }}>
                Pagado
            </option>
        </select>
        @error('estado')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="frecuencia" class="mb-2 block text-sm font-medium text-gray-300">Frecuencia</label>
        <select
            id="frecuencia"
            name="frecuencia"
            class="w-full rounded-xl border border-[#2b3a32] bg-[#111613] px-4 py-3 text-white focus:border-[#72f59a] focus:outline-none"
        >
            <option value="unico" {{ old('frecuencia', $factura->frecuencia ?? 'unico') === 'unico' ? 'selected' : '' }}>
                Único
            </option>
            <option value="recurrente" {{ old('frecuencia', $factura->frecuencia ?? '') === 'recurrente' ? 'selected' : '' }}>
                Recurrente
            </option>
        </select>
        @error('frecuencia')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <button
        type="submit"
        class="inline-flex items-center gap-2 rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-[#0d1510] transition hover:brightness-110"
    >
        <i class="bi bi-check2-circle"></i>
        {{ $boton }}
    </button>

    <a
        href="{{ route('facturas.index') }}"
        class="inline-flex items-center gap-2 rounded-xl border border-[#314238] px-5 py-3 text-sm font-semibold text-gray-300 transition hover:border-[#72f59a] hover:text-white"
    >
        Cancelar
    </a>
</div>