<div class="grid grid-cols-1 gap-4 md:grid-cols-2">

    {{-- TITULO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Título</label>
        <input
            type="text"
            name="titulo"
            value="{{ old('titulo', $transaccion->titulo ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('titulo') ? 'border-red-500' : '' }}"
            placeholder="Supermercado"
        >
        @if($errors->has('titulo'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('titulo') }}</p>
        @endif
    </div>

    {{-- MONTO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Monto (€)</label>
        <input
            type="number"
            step="0.01"
            name="monto"
            value="{{ old('monto', $transaccion->monto ?? '') }}"
            placeholder="50.00"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('monto') ? 'border-red-500' : '' }}"
        >
        @if($errors->has('monto'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('monto') }}</p>
        @endif
    </div>

    {{-- TIPO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Tipo</label>
        <select
            name="tipo_movimiento"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('tipo_movimiento') ? 'border-red-500' : '' }}"
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
        @if($errors->has('tipo_movimiento'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('tipo_movimiento') }}</p>
        @endif
    </div>

    {{-- CATEGORIA --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Categoría</label>
        <select
            name="id_categoria"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('id_categoria') ? 'border-red-500' : '' }}"
        >
            <option value="">Selecciona</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}"
                    {{ old('id_categoria', $transaccion->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @if($errors->has('id_categoria'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('id_categoria') }}</p>
        @endif
    </div>

  
    {{-- FECHA --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Fecha</label>
        <input
            type="date"
            name="fecha_transaccion"
            value="{{ old('fecha_transaccion', isset($transaccion) ? \Carbon\Carbon::parse($transaccion->fecha_transaccion)->format('Y-m-d') : '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('fecha_transaccion') ? 'border-red-500' : '' }}"
        >
        @if($errors->has('fecha_transaccion'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('fecha_transaccion') }}</p>
        @endif
    </div>

    {{-- METODO PAGO --}}
    <div>
        <label class="mb-2 block text-sm text-gray-300">Método de pago</label>
        <input
            type="text"
            name="metodo_pago"
            value="{{ old('metodo_pago', $transaccion->metodo_pago ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a] {{ $errors->has('metodo_pago') ? 'border-red-500' : '' }}"
            placeholder="Tarjeta, efectivo..."
        >
        @if($errors->has('metodo_pago'))
            <p class="mt-2 text-xs text-red-400">{{ $errors->first('metodo_pago') }}</p>
        @endif
    </div>
    </div>

    {{-- DESCRIPCION --}}
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm text-gray-300">Descripción</label>
        <textarea
            name="descripcion"
            rows="3"
            placeholder="Detalles adicionales sobre la transacción..."
            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:ring-2 focus:ring-[#72f59a]"
        >{{ old('descripcion', $transaccion->descripcion ?? '') }}</textarea>
  
    </div>{{-- CUENTA - FUNCIONALIDAD PRÓXIMAMENTE --}}
<div class="col-span-2 rounded-xl border border-[#4a3f1f] bg-[#2a2415] px-4 py-4">

    <div>
        <label class="mb-2 block text-sm text-yellow-100">
            Cuenta
        </label>

        <select
            name="id_cuenta"
            disabled
            class="w-full rounded-xl border border-[#4a3f1f] bg-[#111613] px-4 py-3 text-gray-500 opacity-60 cursor-not-allowed"
        >
            <option value="">
                Selecciona
            </option>

            @foreach ($cuentas as $cuenta)
                <option
                    value="{{ $cuenta->id_cuenta }}"
                    {{ old('id_cuenta', $transaccion->id_cuenta ?? '') == $cuenta->id_cuenta ? 'selected' : '' }}
                >
                    {{ $cuenta->nombre }}
                </option>
            @endforeach
        </select>

        @if($errors->has('id_cuenta'))
            <p class="mt-2 text-xs text-red-400">
                {{ $errors->first('id_cuenta') }}
            </p>
        @endif
    </div>

    <div class="mt-3 flex items-start gap-3 text-sm text-yellow-200">
        <div class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-[#3a3218]">
            <i class="bi bi-info-circle text-sm text-yellow-400"></i>
        </div>

        <p class="leading-tight">
            Próximamente se implementará la funcionalidad de cuentas para que puedas asociar esta transacción a una cuenta específica.
        </p>
    </div>

</div>
</div>