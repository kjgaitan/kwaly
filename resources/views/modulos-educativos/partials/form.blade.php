@php
$niveles = [
'basico' => 'Básico',
'intermedio' => 'Intermedio',
'avanzado' => 'Avanzado',
];
@endphp

<div class="grid gap-5">
    <div>
        <label for="titulo" class="mb-2 block text-sm font-medium text-gray-300">Título</label>
        <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $modulo->titulo ?? '') }}"
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white placeholder:text-gray-500 focus:border-green-500 focus:outline-none"
            placeholder="Fondo de emergencia">
        <x-input-error :messages="$errors->get('titulo')" />

    </div>

    <div>
        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-300">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white placeholder:text-gray-500 focus:border-green-500 focus:outline-none"
            placeholder="Describe brevemente el contenido del módulo">{{ old('descripcion', $modulo->descripcion ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" />

    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="nivel" class="mb-2 block text-sm font-medium text-gray-300">Nivel</label>
            <select id="nivel" name="nivel"
                class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                <option value="">Seleccione</option>
                @foreach($niveles as $valor => $texto)
                <option value="{{ $valor }}" {{ old('nivel', $modulo->nivel ?? '') === $valor ? 'selected' : '' }}>
                    {{ $texto }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('nivel')" />

        </div>

        <div>
            <label for="duracion_minutos" class="mb-2 block text-sm font-medium text-gray-300">Duración
                (minutos)</label>
            <input type="number" id="duracion_minutos" name="duracion_minutos" min="1"
                value="{{ old('duracion_minutos', $modulo->duracion_minutos ?? '') }}"
                class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white placeholder:text-gray-500 focus:border-green-500 focus:outline-none"
                placeholder="10">
            <x-input-error :messages="$errors->get('duracion_minutos')" />

        </div>
    </div>

    <div class="mt-8 flex items-center justify-end gap-3 pr-2 pb-2">

        <a href="{{ route('modulos-educativos.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] px-5 py-3 text-sm font-medium text-white transition hover:bg-white/[0.05]">
            <span>Cancelar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-green-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
            <span>{{ $textoBoton }}</span>
        </button>

    </div>
</div>