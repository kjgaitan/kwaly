@php
    $iconosDisponibles = [
        'bi-cart' => 'Compra',
        'bi-house' => 'Casa',
        'bi-car-front' => 'Transporte',
        'bi-cup-hot' => 'Comida',
        'bi-heart-pulse' => 'Salud',
        'bi-controller' => 'Ocio',
        'bi-book' => 'Educación',
        'bi-gift' => 'Regalos',
        'bi-piggy-bank' => 'Ahorro',
        'bi-cash-coin' => 'Dinero',
    ];

    $coloresDisponibles = [
        'verde' => '#72f59a',
        'azul' => '#3b82f6',
        'rojo' => '#ef4444',
        'amarillo' => '#facc15',
        'morado' => '#8b5cf6',
    ];
@endphp

<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon blue">
            <i class="bi bi-tags"></i>
        </div>

        <h2>{{ __('configuracion.categorias.title') }}</h2>
    </div>

    <div class="categorias-container">

        <div class="categorias-list">
            @if($categorias->count() > 0)
                <div class="categorias-grid">
                    @foreach($categorias as $categoria)
                        <div class="categoria-item">
                            <div class="categoria-info">
                                <div
                                    class="categoria-icon"
                                    style="background-color: {{ $categoria->color_hex ?? '#72f59a' }};"
                                >
                                    <i class="bi {{ $categoria->icono ?: 'bi-tag' }}"></i>
                                </div>

                                <span class="categoria-nombre">
                                    {{ $categoria->nombre }}
                                </span>
                            </div>

                            <div class="categoria-actions">
                                @if($categoria->id_usuario == Auth::user()->id_usuario)
                                    <button
                                        type="button"
                                        class="btn-edit categoria-edit-btn"
                                        title="Editar"
                                        data-update-url="{{ route('categorias.update', $categoria->id_categoria) }}"
                                        data-nombre="{{ $categoria->nombre }}"
                                        data-icono="{{ $categoria->icono ?: 'bi-tag' }}"
                                        data-color="{{ $categoria->color_hex ?? '#72f59a' }}"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <form
                                        action="{{ route('categorias.destroy', $categoria->id_categoria) }}"
                                        method="POST"
                                        class="inline-form"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="categoria-global">Global</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-tags"></i>
                    <p>No hay categorías registradas.</p>
                </div>
            @endif
        </div>

        <div class="categoria-form-section">
            <h3 id="categoriaFormTitle">
                Crear nueva categoría
            </h3>

            <form
                id="categoriaForm"
                action="{{ route('categorias.store') }}"
                method="POST"
                class="config-form"
                data-store-url="{{ route('categorias.store') }}"
            >
                @csrf

                <input
                    type="hidden"
                    name="_method"
                    id="categoria_method"
                    value="POST"
                    disabled
                >

                <div class="config-form-group">
                    <label for="categoria_nombre">Nombre</label>

                    <input
                        id="categoria_nombre"
                        name="nombre"
                        type="text"
                        placeholder="Supermercado"
                        value="{{ old('nombre') }}"
                        required
                    >

                    <x-input-error :messages="$errors->get('nombre')" />
                </div>

                <div class="config-form-group">
                    <label>Icono</label>

                    <input
                        type="hidden"
                        id="icono"
                        name="icono"
                        value="{{ old('icono', 'bi-tag') }}"
                    >

                    <div class="category-icon-options">
                        @foreach($iconosDisponibles as $icono => $texto)
                            <button
                                type="button"
                                class="category-icon-option {{ old('icono', 'bi-tag') === $icono ? 'active' : '' }}"
                                data-icon="{{ $icono }}"
                            >
                                <i class="bi {{ $icono }}"></i>
                                <span>{{ $texto }}</span>
                            </button>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('icono')" />
                </div>

                <div class="config-form-group">
                    <label>Color</label>

                    <input
                        type="hidden"
                        id="color_hex"
                        name="color_hex"
                        value="{{ old('color_hex', '#72f59a') }}"
                    >

                    <div class="category-color-options">
                        @foreach($coloresDisponibles as $clase => $color)
                            <button
                                type="button"
                                class="category-color-option color-{{ $clase }} {{ old('color_hex', '#72f59a') === $color ? 'active' : '' }}"
                                data-color="{{ $color }}"
                            ></button>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('color_hex')" />
                </div>

                <div class="category-preview-box">
                    <span>Vista previa</span>

                    <div class="category-preview-item">
                        <div id="previewCategoriaIcono" class="categoria-icon preview-color">
                            <i class="bi {{ old('icono', 'bi-tag') }}"></i>
                        </div>

                        <strong id="previewCategoriaNombre">
                            {{ old('nombre', 'Vista previa de categoría') }}
                        </strong>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pr-2 pb-2">
                    <button
                        type="button"
                        id="cancelarEdicionCategoria"
                        class="profile-btn-cancel hidden"
                    >
                        Cancelar edición
                    </button>

                    <button
                        type="submit"
                        id="categoriaSubmitBtn"
                        class="config-btn-primary"
                    >
                        Guardar categoría
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>