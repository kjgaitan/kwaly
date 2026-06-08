<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon purple">
            <i class="bi bi-bell"></i>
        </div>
        <h2>{{ __('configuracion.notificaciones.title') }}</h2>
    </div>

    <form action="{{ route('configuracion.notificaciones.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-switch-list">
            <label class="config-switch-item">
                <div>
                    <span>{{ __('configuracion.notificaciones.email') }}</span>
                </div>
                <input type="checkbox" name="notificacion_email" value="1" {{ old('notificacion_email', $configuracion->notificacion_email) ? 'checked' : '' }}>
            </label>

            <label class="config-switch-item">
                <div>
                    <span>{{ __('configuracion.notificaciones.alerta') }}</span>
                </div>
                <input type="checkbox" name="alerta_presupuesto" value="1" {{ old('alerta_presupuesto', $configuracion->alerta_presupuesto) ? 'checked' : '' }}>
            </label>

            <label class="config-switch-item">
                <div>
                    <span>{{ __('configuracion.notificaciones.recordatorio') }}</span>
                </div>
                <input type="checkbox" name="recordatorio_pagos" value="1" {{ old('recordatorio_pagos', $configuracion->recordatorio_pagos) ? 'checked' : '' }}>
            </label>
        </div>

       <div class="flex justify-end">
            <button type="submit" class="config-btn-primary">
                {{ __('configuracion.notificaciones.guardar') }}
            </button>
        </div>
    </form>
</div>
