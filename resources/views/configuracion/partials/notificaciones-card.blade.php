<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon purple">
            <i class="bi bi-bell"></i>
        </div>
        <h2>Notificaciones</h2>
    </div>

    <form action="{{ route('configuracion.notificaciones.update') }}" method="POST" class="config-form">
        @csrf
        @method('PUT')

        <div class="config-switch-list">
            <label class="config-switch-item">
                <div>
                    <span>Notificaciones por email</span>
                    <small>Recibe resúmenes y avisos importantes por correo.</small>
                </div>
                <input type="checkbox" name="notificacion_email" value="1" {{ old('notificacion_email', $configuracion->notificacion_email) ? 'checked' : '' }}>
            </label>

            <label class="config-switch-item">
                <div>
                    <span>Notificaciones push</span>
                    <small>Recibe alertas rápidas dentro de la aplicación.</small>
                </div>
                <input type="checkbox" name="notificacion_push" value="1" {{ old('notificacion_push', $configuracion->notificacion_push) ? 'checked' : '' }}>
            </label>

            <label class="config-switch-item">
                <div>
                    <span>Alertas de presupuesto</span>
                    <small>Avisa cuando estés cerca del límite de gasto.</small>
                </div>
                <input type="checkbox" name="alerta_presupuesto" value="1" {{ old('alerta_presupuesto', $configuracion->alerta_presupuesto) ? 'checked' : '' }}>
            </label>

            <label class="config-switch-item">
                <div>
                    <span>Recordatorios de pagos</span>
                    <small>Recibe avisos de facturas próximas a vencer.</small>
                </div>
                <input type="checkbox" name="recordatorio_pagos" value="1" {{ old('recordatorio_pagos', $configuracion->recordatorio_pagos) ? 'checked' : '' }}>
            </label>
        </div>

        <button type="submit" class="config-btn-primary">
            Guardar configuración
        </button>
    </form>
</div>