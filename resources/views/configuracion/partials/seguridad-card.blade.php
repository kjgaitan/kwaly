<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2>{{ __('configuracion.seguridad.title') }}</h2>
    </div>

    <form action="{{ route('configuracion.seguridad.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-switch-list">
            <label class="config-switch-item">
                <div>
                    <span>{{ __('configuracion.seguridad.2fa') }}</span>
                    <small>{{ __('configuracion.seguridad.2fa_description') }}</small>
                </div>
                <input type="checkbox" name="autenticacion_2fa" value="1" {{ old('autenticacion_2fa', $configuracion->autenticacion_2fa) ? 'checked' : '' }}>
            </label>
        </div>

        <button type="submit" class="config-btn-primary">
            {{ __('configuracion.seguridad.guardar') }}
        </button>
    </form>

    <form action="{{ route('configuracion.password.update') }}" method="POST" class="config-form config-password-form">
        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="password_actual">{{ __('configuracion.seguridad.password_actual') }}</label>
            <input type="password" id="password_actual" name="password_actual">
            <x-input-error :messages="$errors->get('password_actual')" />

        </div>

        <div class="config-form-group">
            <label for="password_nueva">{{ __('configuracion.seguridad.password_nueva') }}</label>
            <input type="password" id="password_nueva" name="password_nueva">
            <x-input-error :messages="$errors->get('password_nueva')" />

        </div>

        <div class="config-form-group">
            <label for="password_nueva_confirmation">{{ __('configuracion.seguridad.password_confirmacion') }}</label>
            <input type="password" id="password_nueva_confirmation" name="password_nueva_confirmation">
        </div>

        <button type="submit" class="config-btn-outline-btn">
            {{ __('configuracion.seguridad.cambiar_password') }}
        </button>
    </form>
</div> 