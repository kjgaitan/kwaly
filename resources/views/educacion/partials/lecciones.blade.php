@if($modulos->isEmpty())
    <div class="rounded-[20px] border border-[#26352d] bg-[#0d1310] p-6 text-center shadow-[0_0_16px_rgba(114,245,154,0.04)]">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500/10 text-green-400">
            <i class="bi bi-journal-bookmark text-2xl"></i>
        </div>

        <h2 class="mt-4 text-lg font-semibold text-white">Aún no hay lecciones disponibles</h2>
        <p class="mt-2 text-sm text-gray-400">
            Cuando registres módulos y lecciones en la base de datos, aparecerán aquí.
        </p>
    </div>
@else
    <div class="grid gap-4 lg:grid-cols-2">
        @foreach($modulos as $modulo)
            @php
                $primeraLeccion = $modulo->lecciones->first();

                $completado = $modulo->lecciones->count() > 0 &&
                    $modulo->lecciones->every(fn($leccion) => in_array($leccion->id_leccion, $progreso));

                $duracionTexto = $modulo->duracion_minutos
                    ? $modulo->duracion_minutos . ' min'
                    : 'Sin tiempo';

                $nivelTexto = $modulo->nivel
                    ? ucfirst($modulo->nivel)
                    : 'Básico';
            @endphp

            <div class="rounded-[20px] border border-[#26352d] bg-[linear-gradient(180deg,#0d1210_0%,#0b100d_100%)] p-4 shadow-[0_0_18px_rgba(114,245,154,0.04)]">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-green-500/15 bg-[radial-gradient(circle,_rgba(83,240,148,0.24),_rgba(83,240,148,0.08)_58%,_transparent_75%)] text-green-300 shadow-[0_0_18px_rgba(83,240,148,0.18)]">
                        <i class="bi {{ $completado ? 'bi-check-circle' : 'bi-bookmark-star' }}"></i>
                    </div>

                    <div class="flex h-7 w-7 items-center justify-center rounded-full border border-green-500/20 bg-green-500/10 text-green-400">
                        <i class="bi {{ $completado ? 'bi-check-circle-fill' : 'bi-arrow-repeat' }} text-xs"></i>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-2 text-[11px] text-gray-400">
                    <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                        {{ $nivelTexto }}
                    </span>

                    <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                        {{ $duracionTexto }}
                    </span>

                    <span class="rounded-full border border-white/8 bg-white/5 px-2 py-1">
                        {{ $modulo->lecciones->count() }} lecciones
                    </span>
                </div>

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
                        Este módulo todavía no tiene contenido disponible.
                    @endif
                </div>

                <div class="mt-4">
                    @if($primeraLeccion)
                        <form method="POST" action="{{ route('educacion.completar', $primeraLeccion->id_leccion) }}">
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl {{ in_array($primeraLeccion->id_leccion, $progreso) ? 'border border-white/5 bg-[#161d19] text-white hover:border-green-500/20 hover:bg-[#1a221d]' : 'bg-green-500 text-black hover:bg-green-400' }} px-4 py-3 text-sm font-medium transition">
                                <span>
                                    {{ in_array($primeraLeccion->id_leccion, $progreso) ? 'Repasar Lección' : 'Comenzar Lección' }}
                                </span>
                                <i class="bi bi-chevron-right text-xs"></i>
                            </button>
                        </form>
                    @else
                        <button
                            type="button"
                            disabled
                            class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-white/5 bg-[#161d19] px-4 py-3 text-sm font-medium text-gray-500">
                            <span>Sin lecciones disponibles</span>
                            <i class="bi bi-chevron-right text-xs"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif