<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm text-gray-300">Presupuesto</label>
        <select name="id_presupuesto" id="id_presupuesto" class="budget-input">
            <option value="">Selecciona un presupuesto</option>
            @foreach($presupuestos as $itemPresupuesto)
            <option value="{{ $itemPresupuesto->id_presupuesto }}" data-mes="{{ $itemPresupuesto->mes }}"
                data-anio="{{ $itemPresupuesto->anio }}"
                data-ingreso="{{ number_format($itemPresupuesto->ingreso_estimado, 2, ',', '.') }}"
                {{ old('id_presupuesto', optional($detalle)->id_presupuesto ?? $presupuesto->id_presupuesto ?? '') == $itemPresupuesto->id_presupuesto ? 'selected' : '' }}>
                {{ $itemPresupuesto->mes }}/{{ $itemPresupuesto->anio }} -
                {{ number_format($itemPresupuesto->ingreso_estimado, 2, ',', '.') }}€
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('id_presupuesto')" />
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Categoría</label>
        <select name="id_categoria" class="budget-input">
            <option value="">Selecciona una categoría</option>
            @foreach($categorias as $categoria)
            <option value="{{ $categoria->id_categoria }}"
                {{ old('id_categoria', optional($detalle)->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('id_categoria')" />
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Tipo de presupuesto</label>
        <select name="tipo_presupuesto" class="budget-input">
            <option value="">Seleccione un tipo</option>
            <option value="necesidades"
                {{ old('tipo_presupuesto', optional($detalle)->tipo_presupuesto ?? '') == 'necesidades' ? 'selected' : '' }}>
                Necesidades
            </option>
            <option value="deseos"
                {{ old('tipo_presupuesto', optional($detalle)->tipo_presupuesto ?? '') == 'deseos' ? 'selected' : '' }}>
                Deseos
            </option>
            <option value="ahorro"
                {{ old('tipo_presupuesto', optional($detalle)->tipo_presupuesto ?? '') == 'ahorro' ? 'selected' : '' }}>
                Ahorro
            </option>
        </select>
        <x-input-error :messages="$errors->get('tipo_presupuesto')" />
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Límite del sobre</label>
        <input type="number" step="0.01" name="limite_monto"
            value="{{ old('limite_monto', optional($detalle)->limite_monto ?? '') }}" class="budget-input"
            placeholder="300.00">
        <x-input-error :messages="$errors->get('limite_monto')" />
    </div>

    <div>
        <label class="mb-2 block text-sm text-gray-300">Monto gastado</label>
        <input type="number" step="0.01" name="monto_gastado"
            value="{{ old('monto_gastado', optional($detalle)->monto_gastado ?? 0) }}" class="budget-input"
            placeholder="120.00">
    </div>
</div>