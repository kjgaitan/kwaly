<div id="form-gasto" class="compartido-form-card">
    <h2 class="compartido-form-title">Registrar gasto compartido</h2>

    <form action="{{ route('compartido.gasto.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        @php
            $miembrosFormulario = $miembros ?? $grupo->miembros ?? collect();
            $pagadorSeleccionado = old('id_usuario_pagador', auth()->user()->id_usuario);
            $categoriasFormulario = $categorias ?? collect();
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
            <label for="id_categoria" class="compartido-label">Categoria</label>
            <select name="id_categoria" id="id_categoria" class="compartido-select dark-select {{ $errors->has('id_categoria') ? 'border-red-500' : '' }}">
                <option value="">Seleccione una categoria</option>
                @foreach($categoriasFormulario as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ (string) old('id_categoria') === (string) $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('id_categoria'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('id_categoria') }}</p>
            @endif
            @if($categoriasFormulario->isEmpty())
                <p class="mt-2 text-xs text-red-400">No tienes categorias disponibles. Crea una categoria en configuracion antes de registrar gastos.</p>
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
            <span class="compartido-label">Personas que participan</span>
            <button type="button" class="compartido-participants-trigger" @click="participantesModalOpen = true">
                <span>
                    <strong x-text="cantidadMiembros"></strong>
                    <span x-text="cantidadMiembros === 1 ? 'persona seleccionada' : 'personas seleccionadas'"></span>
                </span>
                <i class="bi bi-people"></i>
            </button>

            <template x-for="idUsuario in participantes" :key="idUsuario">
                <input type="hidden" name="id_usuarios_participantes[]" :value="idUsuario">
            </template>

            @if($errors->has('id_usuarios_participantes') || $errors->has('id_usuarios_participantes.*'))
                <p class="mt-2 text-xs text-red-400">
                    {{ $errors->first('id_usuarios_participantes') ?: $errors->first('id_usuarios_participantes.*') }}
                </p>
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

        <button type="submit" class="compartido-btn-submit" {{ $categoriasFormulario->isEmpty() ? 'disabled' : '' }}>
            Guardar gasto
        </button>
    </form>

    <div x-cloak
        x-show="participantesModalOpen"
        x-transition.opacity
        class="compartido-modal-backdrop"
        @keydown.escape.window="participantesModalOpen = false">
        <div class="compartido-modal-panel"
            x-show="participantesModalOpen"
            x-transition
            @click.outside="participantesModalOpen = false">
            <div class="compartido-modal-header">
                <div>
                    <h2 class="compartido-form-title">Elegir personas</h2>
                    <p class="compartido-modal-subtitle">Marca solo quienes participaron en este gasto.</p>
                </div>

                <button type="button" class="compartido-icon-button" @click="participantesModalOpen = false">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="compartido-participants-list">
                @foreach($miembrosFormulario as $miembro)
                    <label class="compartido-participant-option">
                        <input type="checkbox"
                            value="{{ $miembro->id_usuario }}"
                            :checked="participantes.map(String).includes('{{ $miembro->id_usuario }}')"
                            @change="toggleParticipante('{{ $miembro->id_usuario }}')">
                        <span>
                            <strong>{{ $miembro->usuario?->nombre ?? 'Usuario sin nombre' }}</strong>
                            <small>{{ $miembro->usuario?->email }}</small>
                        </span>
                    </label>
                @endforeach
            </div>

            <button type="button" class="compartido-btn-submit mt-4" @click="participantesModalOpen = false" :disabled="cantidadMiembros === 0">
                Confirmar seleccion
            </button>
        </div>
    </div>
</div>
