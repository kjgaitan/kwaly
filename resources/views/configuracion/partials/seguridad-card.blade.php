<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h2>{{ __('configuracion.seguridad.title') }}</h2>
    </div>

    <form action="{{ route('configuracion.seguridad.update') }}"
          method="POST"
          class="config-form">

        @csrf
        @method('PUT')

        <div class="config-switch-list">
            <label class="config-switch-item">
                <div>
                    <span>
                        {{ __('configuracion.seguridad.2fa') }}
                    </span>

                    <small>
                        {{ __('configuracion.seguridad.2fa_description') }}
                    </small>
                </div>

                <input type="checkbox"
                       name="autenticacion_2fa"
                       value="1"
                       {{ old('autenticacion_2fa', $configuracion->autenticacion_2fa) ? 'checked' : '' }}>
            </label>
        </div>

        <div class="mt-8 flex justify-end pr-2 pb-2">

            <button type="submit"
                    class="config-btn-primary">
                {{ __('configuracion.seguridad.guardar') }}
            </button>

        </div>

    </form>
</div>