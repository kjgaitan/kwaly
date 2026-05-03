<div class="grid grid-cols-1 gap-4 md:grid-cols-2">

    {{-- TITULO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Título</label>
        <input
            type="text"
            name="titulo"
            value="{{ old('titulo', $transaccion->titulo ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
            placeholder="Supermercado"
        >
    </div>

    {{-- MONTO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Monto (€)</label>
        <input
            type="number"
            step="0.01"
            name="monto"
            value="{{ old('monto', $transaccion->monto ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >
    </div>

    {{-- TIPO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Tipo</label>
        <select
            name="tipo_movimiento"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >
            <option value="">Selecciona</option>
            <option value="ingreso"
                {{ old('tipo_movimiento', $transaccion->tipo_movimiento ?? '') == 'ingreso' ? 'selected' : '' }}>
                Ingreso
            </option>
            <option value="gasto"
                {{ old('tipo_movimiento', $transaccion->tipo_movimiento ?? '') == 'gasto' ? 'selected' : '' }}>
                Gasto
            </option>
        </select>
    </div>

    {{-- CATEGORIA --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Categoría</label>
        <select
            name="id_categoria"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >
            <option value="">Selecciona</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}"
                    {{ old('id_categoria', $transaccion->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                    @if($categoria->icono)
                        {{ $categoria->icono }}
                    @endif
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- CUENTA --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Cuenta</label>
        <select
            name="id_cuenta"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >
            <option value="">Selecciona</option>
            @foreach ($cuentas as $cuenta)
                <option value="{{ $cuenta->id_cuenta }}"
                    {{ old('id_cuenta', $transaccion->id_cuenta ?? '') == $cuenta->id_cuenta ? 'selected' : '' }}>
                    {{ $cuenta->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- FECHA --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Fecha</label>
        <input
            type="date"
            name="fecha_transaccion"
            value="{{ old('fecha_transaccion', isset($transaccion) ? \Carbon\Carbon::parse($transaccion->fecha_transaccion)->format('Y-m-d') : '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >
    </div>

    {{-- METODO PAGO --}}
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm text-gray-300">Método de pago</label>
        <input
            type="text"
            name="metodo_pago"
            value="{{ old('metodo_pago', $transaccion->metodo_pago ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
            placeholder="Tarjeta, efectivo..."
        >
    </div>

    {{-- DESCRIPCION --}}
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm text-gray-300">Descripción</label>
        <textarea
            name="descripcion"
            rows="3"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >{{ old('descripcion', $transaccion->descripcion ?? '') }}</textarea>
    </div>

</div>