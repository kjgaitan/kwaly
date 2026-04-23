<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-person"></i>
        </div>
        <h2>Perfil</h2>
    </div>

    <form action="{{ route('configuracion.perfil.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
            @error('nombre')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}">
            @error('email')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}">
            @error('telefono')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="config-btn-primary">
            Guardar cambios
        </button>
    </form>
</div>