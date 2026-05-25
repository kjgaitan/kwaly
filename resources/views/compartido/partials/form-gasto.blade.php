<div id="form-gasto" class="compartido-form-card">
    <h2 class="compartido-form-title">Registrar gasto compartido</h2>

    <form action="{{ route('compartido.gasto.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        @php
            $miembrosFormulario = $miembros ?? $grupo->miembros ?? collect();
            $pagadorSeleccionado = old('id_usuario_pagador', auth()->user()->id_usuario);
            $categoriasGasto = ['Supermercado', 'Restaurante', 'Transporte', 'Facturas', 'Ocio', 'Hogar', 'Otros'];
        @endphp

        <div class="compartido-form-group">
            <label for="titulo" class="compartido-label">Titulo del gasto</label>
            <input type="text"
                   name="titulo"
                   id="titulo"
                   value="{{ old('titulo') }}"
                   placeholder="Compra del supermercado"
                   class="compartido-input {{ $errors->has('titulo') ? 'border-red-500' : '' }}">
            @if($errors->has('titulo'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('titulo') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="categoria" class="compartido-label">Categoria</label>
            <select name="categoria" id="categoria" class="compartido-select dark-select {{ $errors->has('categoria') ? 'border-red-500' : '' }}">
                <option value="">Seleccione una categoria</option>
                @foreach($categoriasGasto as $categoria)
                    <option value="{{ $categoria }}" {{ old('categoria') === $categoria ? 'selected' : '' }}>
                        {{ $categoria }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('categoria'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('categoria') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="monto_total" class="compartido-label">Monto total</label>
            <input type="number"
                   step="0.01"
                   min="0.01"
                   max="999999.99"
                   name="monto_total"
                   id="monto_total"
                   x-model="monto"
                   value="{{ old('monto_total') }}"
                   placeholder="45.90"
                   class="compartido-input {{ $errors->has('monto_total') ? 'border-red-500' : '' }}">
            @if($errors->has('monto_total'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('monto_total') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="id_usuario_pagador" class="compartido-label">Pagado por</label>
            <select name="id_usuario_pagador"
                    id="id_usuario_pagador"
                    x-model="pagador"
                    class="compartido-select dark-select {{ $errors->has('id_usuario_pagador') ? 'border-red-500' : '' }}">
                <option value="" disabled {{ old('id_usuario_pagador') === '' ? 'selected' : '' }}>Seleccione un miembro</option>
                @foreach($miembrosFormulario as $miembro)
                    <option value="{{ $miembro->id_usuario }}" {{ (string) $pagadorSeleccionado === (string) $miembro->id_usuario ? 'selected' : '' }}>
                        {{ $miembro->usuario?->nombre ?? 'Usuario sin nombre' }}{{ auth()->user()->id_usuario === $miembro->id_usuario ? ' (tu)' : '' }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('id_usuario_pagador'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('id_usuario_pagador') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="fecha_gasto" class="compartido-label">Fecha del gasto</label>
            <input type="date"
                   name="fecha_gasto"
                   id="fecha_gasto"
                   value="{{ old('fecha_gasto', now()->format('Y-m-d')) }}"
                   class="compartido-input dark-date-input {{ $errors->has('fecha_gasto') ? 'border-red-500' : '' }}">
            @if($errors->has('fecha_gasto'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('fecha_gasto') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="descripcion" class="compartido-label">Descripcion opcional</label>
            <textarea name="descripcion"
                      id="descripcion"
                      rows="3"
                      placeholder="Compra semanal para el piso"
                      class="compartido-textarea {{ $errors->has('descripcion') ? 'border-red-500' : '' }}">{{ old('descripcion') }}</textarea>
            @if($errors->has('descripcion'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('descripcion') }}</p>
            @endif
        </div>

        <button type="submit" class="compartido-btn-submit">
            Guardar gasto
        </button>
    </form>
</div>
