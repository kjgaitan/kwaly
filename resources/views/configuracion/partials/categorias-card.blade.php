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

    <div class="categoria-form-section">

        <form action="{{ route('categorias.store') }}"
              method="POST"
              class="config-form">

            @csrf

            <div class="config-form-group">

                <label for="categoria_nombre">
                    Nombre
                </label>

                <input
                    id="categoria_nombre"
                    name="nombre"
                    type="text"
                    placeholder="Supermercado"
                    value="{{ old('nombre') }}"
                    required
                >

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
                        >
                        </button>

                    @endforeach

                </div>

            </div>


            <div class="category-preview-box">

                <span>Vista previa</span>

                <div class="category-preview-item">

                  <div
                         id="previewCategoriaIcono"
                         class="categoria-icon preview-color"
                        >
                        <i class="bi {{ old('icono', 'bi-tag') }}"></i>
                    </div>

                    <strong id="previewCategoriaNombre">
                        {{ old('nombre', 'Vista previa de categoría') }}
                    </strong>

                </div>

            </div>


            <div class="mt-8 flex justify-end pr-2 pb-2">

                <button
                    type="submit"
                    class="config-btn-primary"
                >
                    Guardar categoría
                </button>

            </div>

        </form>

    </div>

</div>