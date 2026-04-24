<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-person"></i>
        </div>
        <h2>{{ __('configuracion.perfil.title') }}</h2>
    </div>

    <form action="{{ route('configuracion.perfil.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="nombre">{{ __('configuracion.perfil.nombre') }}</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
            @error('nombre')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="email">{{ __('configuracion.perfil.email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}">
            @error('email')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="telefono">{{ __('configuracion.perfil.telefono') }}</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}">
            @error('telefono')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="config-btn-primary">
            {{ __('configuracion.perfil.guardar') }}
        </button>
    </form>
</div> 