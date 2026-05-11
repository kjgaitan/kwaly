@php
    $metaActual = $meta ?? null;
@endphp

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    <div class="md:col-span-2">
        <label for="titulo" class="mb-2 block text-sm font-medium text-white">
            Título de la meta
        </label>
        <input type="text"
               name="titulo"
               id="titulo"
               value="{{ old('titulo', $metaActual->titulo ?? '') }}"
               placeholder="Fondo de emergencia"
               class="metas-input">
        <x-input-error :messages="$errors->get('titulo')" />
    </div>

    <div class="md:col-span-2">
        <label for="descripcion" class="mb-2 block text-sm font-medium text-white">
            Descripción
        </label>
        <textarea name="descripcion"
                  id="descripcion"
                  rows="4"
                  placeholder="Describe brevemente el objetivo de esta meta"
                  class="metas-textarea">{{ old('descripcion', $metaActual->descripcion ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" />
    </div>

    <div>
        <label for="monto_objetivo" class="mb-2 block text-sm font-medium text-white">
            Monto objetivo (€)
        </label>
        <input type="number"
               step="0.01"
               min="0.01"
               name="monto_objetivo"
               id="monto_objetivo"
               value="{{ old('monto_objetivo', $metaActual->monto_objetivo ?? '') }}"
               placeholder="0.00"
               class="metas-input">
        <x-input-error :messages="$errors->get('monto_objetivo')" />
    </div>

    <div>
        <label for="monto_actual" class="mb-2 block text-sm font-medium text-white">
            Monto actual (€)
        </label>
        <input type="number"
               step="0.01"
               min="0"
               name="monto_actual"
               id="monto_actual"
               value="{{ old('monto_actual', $metaActual->monto_actual ?? 0) }}"
               placeholder="0.00"
               class="metas-input">
        <x-input-error :messages="$errors->get('monto_actual')" />
    </div>

    <div>
        <label for="fecha_inicio" class="mb-2 block text-sm font-medium text-white">
            Fecha de inicio
        </label>
        <input type="date"
               name="fecha_inicio"
               id="fecha_inicio"
               value="{{ old('fecha_inicio', isset($metaActual->fecha_inicio) ? \Carbon\Carbon::parse($metaActual->fecha_inicio)->format('Y-m-d') : now()->format('Y-m-d')) }}"
               class="metas-date">
        <x-input-error :messages="$errors->get('fecha_inicio')" />
    </div>

    <div>
        <label for="fecha_limite" class="mb-2 block text-sm font-medium text-white">
            Fecha límite
        </label>
        <input type="date"
               name="fecha_limite"
               id="fecha_limite"
               value="{{ old('fecha_limite', isset($metaActual->fecha_limite) ? \Carbon\Carbon::parse($metaActual->fecha_limite)->format('Y-m-d') : '') }}"
               class="metas-date">
    </div>

    <div>
        <label for="prioridad" class="mb-2 block text-sm font-medium text-white">
            Prioridad
        </label>
        <select name="prioridad" id="prioridad" class="metas-select">
            <option value="" disabled {{ old('prioridad', $metaActual->prioridad ?? '') === '' ? 'selected' : '' }}>Seleccione prioridad</option>
            <option value="baja" {{ old('prioridad', $metaActual->prioridad ?? '') === 'baja' ? 'selected' : '' }}>Baja</option>
            <option value="media" {{ old('prioridad', $metaActual->prioridad ?? '') === 'media' ? 'selected' : '' }}>Media</option>
            <option value="alta" {{ old('prioridad', $metaActual->prioridad ?? '') === 'alta' ? 'selected' : '' }}>Alta</option>
        </select>
        <x-input-error :messages="$errors->get('prioridad')" />
    </div>

    <div>
        <label for="estado" class="mb-2 block text-sm font-medium text-white">
            Estado
        </label>
        <select name="estado" id="estado" class="metas-select">
            <option value="" disabled {{ old('estado', $metaActual->estado ?? '') === '' ? 'selected' : '' }}>Seleccione estado</option>
            <option value="activa" {{ old('estado', $metaActual->estado ?? '') === 'activa' ? 'selected' : '' }}>Activa</option>
            <option value="completada" {{ old('estado', $metaActual->estado ?? '') === 'completada' ? 'selected' : '' }}>Completada</option>
            <option value="pausada" {{ old('estado', $metaActual->estado ?? '') === 'pausada' ? 'selected' : '' }}>Pausada</option>
        </select>
        <x-input-error :messages="$errors->get('estado')" />
    </div>
</div>