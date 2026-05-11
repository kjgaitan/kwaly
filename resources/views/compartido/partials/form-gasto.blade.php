<div id="form-gasto" class="compartido-form-card">
    <h2 class="compartido-form-title">Registrar Gasto Compartido</h2>

    <form action="{{ route('compartido.gasto.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        <div class="compartido-form-group">
            <label for="titulo" class="compartido-label">Título del gasto</label>
            <input type="text"
                   name="titulo"
                   id="titulo"
                   value="{{ old('titulo') }}"
                   placeholder="Ej: Compra del supermercado"
                   class="compartido-input {{ $errors->has('titulo') ? 'border-red-500' : '' }}">
            @if($errors->has('titulo'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('titulo') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="monto_total" class="compartido-label">Monto total</label>
            <input type="number"
                   step="0.01"
                   min="0.01"
                   name="monto_total"
                   id="monto_total"
                   value="{{ old('monto_total') }}"
                   placeholder="0.00"
                   class="compartido-input {{ $errors->has('monto_total') ? 'border-red-500' : '' }}">
            @if($errors->has('monto_total'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('monto_total') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="fecha_gasto" class="compartido-label">Fecha del gasto</label>
            <input type="date"
                   name="fecha_gasto"
                   id="fecha_gasto"
                   value="{{ old('fecha_gasto', now()->format('Y-m-d')) }}"
                   class="compartido-input dark-date-input {{ $errors->has('fecha_gasto') ? 'border-red-500' : '' }}">
            @if($errors->has('fecha_gasto'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('fecha_gasto') }}</p>
            @endif
        </div>

        <button type="submit" class="compartido-btn-submit">
            Guardar gasto
        </button>
    </form>
</div>