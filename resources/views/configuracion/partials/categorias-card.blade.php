<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon blue">
            <i class="bi bi-tags"></i>
        </div>
        <h2>{{ __('configuracion.categorias.title') }}</h2>
    </div>

    <div class="categorias-container">
        <!-- Listado de categorías existentes -->
        <div class="categorias-list">
            @if($categorias->count() > 0)
                <div class="categorias-grid">
                    @foreach($categorias as $categoria)
                        <div class="categoria-item">
                            <div class="categoria-info">
                                <div class="categoria-icon" style="background-color: {{ $categoria->color_hex ?? '#6B7280' }};">
                                    @if($categoria->icono)
                                        <i class="bi {{ $categoria->icono }}"></i>
                                    @else
                                        <i class="bi bi-tag"></i>
                                    @endif
                                </div>
                                <span class="categoria-nombre">{{ $categoria->nombre }}</span>
                            </div>
                            <div class="categoria-actions">
                                @if($categoria->id_usuario == Auth::user()->id_usuario)
                                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn-edit" title="{{ __('configuracion.categorias.editar') }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" class="inline-form" onsubmit="return confirm('{{ __('configuracion.categorias.confirmar_eliminar') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="{{ __('configuracion.categorias.eliminar') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="categoria-global">{{ __('configuracion.categorias.global') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-tags"></i>
                    <p>{{ __('configuracion.categorias.vacia') }}</p>
                </div>
            @endif
        </div>

        <!-- Formulario para crear nueva categoría -->
        <div class="categoria-form-section">
            <h3>{{ __('configuracion.categorias.nueva.title') }}</h3>
            <form action="{{ route('categorias.store') }}" method="POST" class="config-form">
                @csrf

                <div class="config-form-group">
                    <label for="nombre">{{ __('configuracion.categorias.nueva.nombre') }}</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="100">
                    <x-input-error :messages="$errors->get('nombre')" />
                </div>

                <div class="config-form-group">
                    <label for="icono">{{ __('configuracion.categorias.nueva.icono') }}</label>
                    <div class="icon-selector">
                        <input type="text" id="icono" name="icono" value="{{ old('icono') }}" placeholder="bi bi-tag" maxlength="100">
                        <div class="icon-preview">
                            <i class="bi {{ old('icono', 'bi bi-tag') }}"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('icono')" />
                    <small class="form-hint">{{ __('configuracion.categorias.nueva.icono_hint') }}</small>
                </div>

                <div class="config-form-group">
                    <label for="color_hex">{{ __('configuracion.categorias.nueva.color') }}</label>
                    <div class="color-input-group">
                        <input type="color" id="color_hex" name="color_hex" value="{{ old('color_hex', '#6B7280') }}" class="color-picker">
                        <input type="text" id="color_hex_text" name="color_hex_text" value="{{ old('color_hex', '#6B7280') }}" class="color-text" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                    <x-input-error :messages="$errors->get('color_hex')" />
                </div>

                <button type="submit" class="config-btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    {{ __('configuracion.categorias.nueva.guardar') }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconoInput = document.getElementById('icono');
    const iconPreview = document.querySelector('.icon-preview i');
    const colorPicker = document.getElementById('color_hex');
    const colorText = document.getElementById('color_hex_text');

    // Preview icono
    if (iconoInput && iconPreview) {
        iconoInput.addEventListener('input', function() {
            const iconClass = this.value || 'bi bi-tag';
            iconPreview.className = 'bi ' + iconClass;
        });
    }

    // Sincronizar color picker con texto
    if (colorPicker && colorText) {
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });

        colorText.addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                colorPicker.value = this.value;
            }
        });
    }
});
</script>
