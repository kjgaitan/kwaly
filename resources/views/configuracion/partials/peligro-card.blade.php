<div class="config-card danger">
    <div class="config-card-title">
        <div class="config-icon red">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <h2>{{ __('configuracion.peligro.title') }}</h2>
    </div>

    <div class="config-actions">
        <a href="{{ route('configuracion.exportar') }}" class="config-btn-danger-outline">
            {{ __('configuracion.peligro.exportar') }}
        </a>
    </div>

    <form action="{{ route('configuracion.destroy') }}" method="POST" class="config-form">
        @csrf
        @method('DELETE')

        <div class="config-form-group">
            <label for="password_confirmacion">{{ __('configuracion.peligro.confirmar_password') }}</label>
            <input type="password" id="password_confirmacion" name="password_confirmacion">
            @error('password_confirmacion')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="config-btn-danger-outline-btn">
            {{ __('configuracion.peligro.eliminar') }}
        </button>
    </form>
</div>