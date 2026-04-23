<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2>Seguridad</h2>
    </div>

    <form action="{{ route('configuracion.seguridad.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-switch-list">
            <label class="config-switch-item">
                <div>
                    <span>Autenticación de dos factores</span>
                    <small>Activa una capa extra de protección para tu cuenta.</small>
                </div>
                <input type="checkbox" name="autenticacion_2fa" value="1" {{ old('autenticacion_2fa', $configuracion->autenticacion_2fa) ? 'checked' : '' }}>
            </label>
        </div>

        <button type="submit" class="config-btn-primary">
            Guardar seguridad
        </button>
    </form>

    <form action="{{ route('configuracion.password.update') }}" method="POST" class="config-form config-password-form">
        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="password_actual">Contraseña actual</label>
            <input type="password" id="password_actual" name="password_actual">
            @error('password_actual')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="password_nueva">Nueva contraseña</label>
            <input type="password" id="password_nueva" name="password_nueva">
            @error('password_nueva')
                <small class="config-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="config-form-group">
            <label for="password_nueva_confirmation">Confirmar nueva contraseña</label>
            <input type="password" id="password_nueva_confirmation" name="password_nueva_confirmation">
        </div>

        <button type="submit" class="config-btn-outline-btn">
            Cambiar contraseña
        </button>
    </form>
</div>