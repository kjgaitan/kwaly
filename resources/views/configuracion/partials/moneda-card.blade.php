<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon blue">
            <i class="bi bi-currency-exchange"></i>
        </div>
        <h2>Moneda</h2>
    </div>

    <form action="{{ route('configuracion.moneda.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="moneda_preferida">Moneda principal</label>
            <select id="moneda_preferida" name="moneda_preferida">
                @foreach($monedas as $codigo => $nombre)
                    <option value="{{ $codigo }}" {{ old('moneda_preferida', $usuario->moneda_preferida ?? 'EUR') == $codigo ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            @error('moneda_preferida')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="config-btn-primary">
            Guardar moneda
        </button>
    </form>
</div>