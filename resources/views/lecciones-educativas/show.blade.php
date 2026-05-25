<x-app-layout>
    @php
        $duracionLeccionTexto = $leccion->duracion_minutos >= 1 && $leccion->duracion_minutos <= 180
            ? $leccion->duracion_minutos . ' min'
            : 'Duración por revisar';
    @endphp

    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="mx-auto max-w-5xl">
            <div class="overflow-hidden rounded-[28px] border border-[#26352d] bg-[#0b100d] shadow-[0_0_24px_rgba(114,245,154,0.06)]">
                <div class="bg-[radial-gradient(circle_at_top_right,_rgba(38,180,91,0.22),_transparent_34%),linear-gradient(135deg,#101612_0%,#0d2015_100%)] px-5 py-6 md:px-8 md:py-8">
                    <div class="grid gap-6 lg:grid-cols-[1fr_260px] lg:items-start">
                        <div>
                            <a href="{{ route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo]) }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-green-300 transition hover:text-green-200">
                                <i class="bi bi-arrow-left"></i>
                                <span>{{ $modulo->titulo }}</span>
                            </a>

                            <p class="mt-5 text-xs font-semibold uppercase tracking-[0.18em] text-green-300/80">
                                Lección {{ $posicionActual }} de {{ $totalLeccionesModulo }}
                            </p>

                            <h1 class="mt-2 max-w-3xl text-3xl font-bold leading-tight text-white md:text-4xl">
                                {{ $leccion->titulo }}
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-6 text-gray-300">
                                Lee el contenido a tu ritmo. Cuando termines, guarda tu avance para actualizar el progreso del módulo.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-black/15 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs font-semibold text-gray-300">Progreso del módulo</span>
                                <span class="text-sm font-bold text-green-300">{{ $porcentajeModulo }}%</span>
                            </div>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full rounded-full bg-green-400 transition-all duration-500"
                                    style="width: {{ $porcentajeModulo }}%;"></div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                                <span class="rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-gray-300">
                                    {{ $leccionesCompletadasModulo }}/{{ $totalLeccionesModulo }} completadas
                                </span>
                                <span class="rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-gray-300">
                                    {{ $duracionLeccionTexto }}
                                </span>
                            </div>

                            <div class="mt-2 rounded-xl border {{ $completada ? 'border-green-500/20 bg-green-500/10 text-green-300' : 'border-yellow-500/20 bg-yellow-500/10 text-yellow-200' }} px-3 py-2 text-xs font-semibold">
                                {{ $completada ? 'Lección completada' : 'Lección pendiente' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 px-5 py-5 md:px-8 md:py-7 lg:grid-cols-[minmax(0,1fr)_260px]">
                    <article class="rounded-[22px] border border-[#26352d] bg-[#111714] p-5 text-base leading-8 text-gray-200 md:p-7">
                        {!! nl2br(e($leccion->contenido)) !!}
                    </article>

                    <aside class="space-y-4">
                        <div class="rounded-[22px] border border-[#26352d] bg-[#101612] p-5">
                            @if($completada)
                                <div class="flex items-start gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-green-500/20 bg-green-500/10 text-green-400">
                                        <i class="bi bi-check2-circle text-xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-semibold text-white">Ya completaste esta lección</h2>
                                        <p class="mt-2 text-sm leading-6 text-gray-400">
                                            Puedes repasarla cuando quieras. El progreso no se duplicará.
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-yellow-500/20 bg-yellow-500/10 text-yellow-300">
                                        <i class="bi bi-hourglass-split text-xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-semibold text-white">Pendiente de completar</h2>
                                        <p class="mt-2 text-sm leading-6 text-gray-400">
                                            Cuando termines de estudiar esta lección, guarda tu avance.
                                        </p>
                                    </div>
                                </div>

                                <form action="{{ route('educacion.completar', $leccion->id_leccion) }}" method="POST" class="mt-5">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                                        <i class="bi bi-check2-all"></i>
                                        <span>Completar lección</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('modulos-educativos.lecciones.edit', ['modulo' => $modulo->id_modulo, 'leccion' => $leccion->id_leccion]) }}"
                                class="flex w-full items-center justify-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-semibold text-green-400 transition hover:bg-green-500/20">
                                <i class="bi bi-pencil-square"></i>
                                <span>Editar lección</span>
                            </a>

                            <a href="{{ route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo]) }}"
                                class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/[0.06]">
                                <i class="bi bi-list-ul"></i>
                                <span>Ver todas las lecciones</span>
                            </a>
                        </div>
                    </aside>
                </div>

                <div class="grid grid-cols-1 gap-3 border-t border-[#26352d] px-5 py-5 md:grid-cols-2 md:px-8">
                    @if($leccionAnterior)
                        <a href="{{ route('modulos-educativos.lecciones.show', ['modulo' => $modulo->id_modulo, 'leccion' => $leccionAnterior->id_leccion]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/[0.06]">
                            <i class="bi bi-chevron-left"></i>
                            <span>Lección anterior</span>
                        </a>
                    @else
                        <div class="hidden md:block"></div>
                    @endif

                    @if($leccionSiguiente)
                        <a href="{{ route('modulos-educativos.lecciones.show', ['modulo' => $modulo->id_modulo, 'leccion' => $leccionSiguiente->id_leccion]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                            <span>Siguiente lección</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                            <span>Terminar repaso</span>
                            <i class="bi bi-check2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
