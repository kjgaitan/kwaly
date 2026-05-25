@if($modulos->isEmpty())
<div
    class="rounded-[20px] border border-[#26352d] bg-[#0d1310] p-6 text-center shadow-[0_0_16px_rgba(114,245,154,0.04)]">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500/10 text-green-400">
        <i class="bi bi-journal-bookmark text-2xl"></i>
    </div>

    <h2 class="mt-4 text-lg font-semibold text-white">No hay módulos educativos</h2>
    <p class="mt-2 text-sm text-gray-400">
        Crea el primer módulo para poder añadir lecciones y mostrar contenido al usuario.
    </p>

    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
        <a href="{{ route('modulos-educativos.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
            <i class="bi bi-plus-circle"></i>
            Crear módulo
        </a>
    </div>
</div>
@else
<div class="grid gap-4 lg:grid-cols-2">
    @foreach($modulos as $modulo)
    @php
    $primeraLeccion = $modulo->lecciones->first();
    $primeraLeccionCompletada = $primeraLeccion && in_array($primeraLeccion->id_leccion, $progreso);
    $cantidadLecciones = $modulo->lecciones->count();
    $leccionesConDuracionValida = $modulo->lecciones->filter(fn($leccion) => $leccion->duracion_minutos >= 1 && $leccion->duracion_minutos <= 180);
    $duracionesPorRevisar = $cantidadLecciones - $leccionesConDuracionValida->count();
    $duracionRealMinutos = $leccionesConDuracionValida->sum('duracion_minutos');

    $completado = $cantidadLecciones > 0 &&
    $modulo->lecciones->every(fn($leccion) => in_array($leccion->id_leccion, $progreso));

    $duracionTexto = $cantidadLecciones > 0
    ? ($duracionesPorRevisar > 0 ? 'Duración por revisar' : $duracionRealMinutos . ' min')
    : 'Sin lecciones';

    $nivelTexto = $modulo->nivel
    ? ucfirst($modulo->nivel)
    : 'Básico';
    @endphp

    <div
        class="rounded-[20px] border border-[#26352d] bg-[linear-gradient(180deg,#0d1210_0%,#0b100d_100%)] p-4 shadow-[0_0_18px_rgba(114,245,154,0.04)]">
        <div class="flex items-start justify-between gap-3">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl border border-green-500/15 bg-[radial-gradient(circle,_rgba(83,240,148,0.24),_rgba(83,240,148,0.08)_58%,_transparent_75%)] text-green-300 shadow-[0_0_18px_rgba(83,240,148,0.18)]">
                <i class="bi {{ $completado ? 'bi-check-circle' : 'bi-bookmark-star' }}"></i>
            </div>

            <div
                class="flex h-7 w-7 items-center justify-center rounded-full border border-green-500/20 bg-green-500/10 text-green-400">
                <i class="bi {{ $completado ? 'bi-check-circle-fill' : 'bi-arrow-repeat' }} text-xs"></i>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-2 text-[11px] text-gray-400">
            <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                {{ $nivelTexto }}
            </span>

            <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                {{ $duracionTexto }}
            </span>

            <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                {{ $cantidadLecciones }} lecciones
            </span>
        </div>

        <p class="mt-2 text-xs leading-5 text-gray-500">
            @if($cantidadLecciones > 0)
                @if($duracionesPorRevisar > 0)
                    Hay lecciones con una duración fuera del rango permitido. Edita esas lecciones para corregir el cálculo.
                @else
                    La duración muestra la suma real de las lecciones creadas en este módulo.
                @endif
            @else
                El módulo todavía no tiene duración porque la duración se calcula desde sus lecciones.
            @endif
        </p>

        <h3 class="mt-4 text-lg font-semibold text-white">
            {{ $modulo->titulo }}
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            {{ $modulo->descripcion }}
        </p>

        <div class="mt-4 rounded-xl border border-white/5 bg-white/[0.03] px-4 py-3 text-sm leading-6 text-gray-300">
            @if($primeraLeccion && !empty($primeraLeccion->contenido))
            {{ \Illuminate\Support\Str::limit($primeraLeccion->contenido, 170) }}
            @else
            <span class="text-gray-500">
                Este módulo todavía no tiene lecciones. Crea la primera para que los usuarios puedan empezar.
            </span>
            @endif
        </div>

        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">

            @if($primeraLeccion)
            <a href="{{ route('modulos-educativos.lecciones.show', ['modulo' => $modulo->id_modulo, 'leccion' => $primeraLeccion->id_leccion]) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl {{ $primeraLeccionCompletada ? 'border border-white/5 bg-[#161d19] text-white hover:border-green-500/20 hover:bg-[#1a221d]' : 'bg-green-500 text-black hover:bg-green-400' }} px-4 py-3 text-sm font-medium transition">
                <span>
                    {{ $primeraLeccionCompletada ? 'Repasar lección' : 'Comenzar lección' }}
                </span>
                <i class="bi bi-chevron-right text-xs"></i>
            </a>

            <a href="{{ route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo]) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-medium text-white transition hover:bg-white/[0.06]">
                <i class="bi bi-collection-play"></i>
                <span>Ver lecciones</span>
            </a>
            @else
            <a href="{{ route('modulos-educativos.lecciones.create', ['modulo' => $modulo->id_modulo]) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-medium text-black transition hover:bg-green-400">
                <i class="bi bi-plus-circle"></i>
                <span>Crear lección</span>
            </a>
            @endif

            <a href="{{ route('modulos-educativos.edit', ['modulo' => $modulo->id_modulo]) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-semibold text-green-400 transition hover:bg-green-500/20">
                <i class="bi bi-pencil-square"></i>
                <span>Editar módulo</span>
            </a>

            <button type="button" onclick="openDeleteModal('deleteModal-modulo-{{ $modulo->id_modulo }}')"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/20">
                <i class="bi bi-trash3"></i>
                <span>Eliminar módulo</span>
            </button>

        </div>
        <x-delete-modal id="deleteModal-modulo-{{ $modulo->id_modulo }}" title="¿Eliminar módulo educativo?"
            message="Este módulo y sus lecciones asociadas se eliminarán permanentemente. Esta operación es irreversible."
            :action="route('modulos-educativos.destroy', ['modulo' => $modulo->id_modulo])"
            method="DELETE" />
    </div>
    @endforeach
</div>
@endif
