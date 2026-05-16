<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm text-gray-300">Categoría</label>
        <select name="id_categoria" class="budget-input">
            <option value="">Selecciona una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}"
                    {{ old('id_categoria', $detalle->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Límite del sobre</label>
        <input
            type="number"
            step="0.01"
            name="limite_monto"
            value="{{ old('limite_monto', $detalle->limite_monto ?? '') }}"
            class="budget-input"
            placeholder="300.00"
        >
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Monto gastado</label>
        <input
            type="number"
            step="0.01"
            name="monto_gastado"
            value="{{ old('monto_gastado', $detalle->monto_gastado ?? 0) }}"
            class="budget-input"
            placeholder="120.00"
        >
    </div>
</div>