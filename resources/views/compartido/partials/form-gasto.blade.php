<div id="form-gasto" class="compartido-form-card">
    <h2 class="compartido-form-title">Registrar Gasto Compartido</h2>

    <form action="{{ route('compartido.gasto.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        <div class="compartido-form-group">
            <label for="titulo" class="compartido-label">Título del gasto</label>
            <input type="text"
                   name="titulo"
                   id="titulo"
                   value="{{ old('titulo') }}"
                   placeholder="Ej: Compra del supermercado"
                   class="compartido-input">
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
                   class="compartido-input">
        </div>

        <div class="compartido-form-group">
            <label for="fecha_gasto" class="compartido-label">Fecha del gasto</label>
            <input type="date"
                   name="fecha_gasto"
                   id="fecha_gasto"
                   value="{{ old('fecha_gasto', now()->format('Y-m-d')) }}"
                   class="compartido-input dark-date-input">
        </div>

        <button type="submit" class="compartido-btn-submit">
            Guardar gasto
        </button>
    </form>
</div>