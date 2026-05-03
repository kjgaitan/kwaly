<div class="compartido-empty-grid">
    <div class="compartido-card compartido-card-padding-lg">
        <div class="compartido-empty-top">
            <div class="compartido-empty-icon">
                <i class="bi bi-people"></i>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-white">No hay grupos compartidos creados</h2>
                <p class="text-sm text-gray-400 mt-1">
                    Crea un grupo para empezar a compartir gastos con otras personas.
                </p>
            </div>
        </div>

        <div class="compartido-empty-box">
            <h3 class="compartido-empty-box-title">¿Qué podrás hacer?</h3>
            <ul class="compartido-empty-list">
                <li>• Registrar gastos grupales</li>
                <li>• Invitar a miembros</li>
                <li>• Ver saldos automáticos</li>
                <li>• Controlar aportaciones de cada persona</li>
            </ul>
        </div>
    </div>

    <div class="compartido-card compartido-card-padding-lg">
        <h2 class="compartido-form-title">Crear grupo compartido</h2>

        <form action="{{ route('compartido.grupo.store') }}" method="POST">
            @csrf

            <div class="compartido-form-group">
                <label for="nombre_grupo" class="compartido-label">Nombre del grupo</label>
                <input type="text"
                       name="nombre_grupo"
                       id="nombre_grupo"
                       value="{{ old('nombre_grupo') }}"
                       placeholder="Piso Zaragoza"
                       class="compartido-input">
            </div>

            <div class="compartido-form-group">
                <label for="descripcion" class="compartido-label">Descripción</label>
                <textarea name="descripcion"
                          id="descripcion"
                          rows="4"
                          placeholder="Describe el propósito del grupo"
                          class="compartido-textarea">{{ old('descripcion') }}</textarea>
            </div>

            <button type="submit" class="compartido-btn-submit">
                Crear grupo
            </button>
        </form>
    </div>
</div>