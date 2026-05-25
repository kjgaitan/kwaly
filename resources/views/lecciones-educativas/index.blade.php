<x-app-layout>
    @php
        $leccionesConDuracionValida = $lecciones->filter(fn($leccion) => $leccion->duracion_minutos >= 1 && $leccion->duracion_minutos <= 180);
        $duracionesPorRevisar = $lecciones->count() - $leccionesConDuracionValida->count();
        $duracionTotalLecciones = $leccionesConDuracionValida->sum('duracion_minutos');
        $duracionModuloTexto = $lecciones->isNotEmpty()
            ? ($duracionesPorRevisar > 0 ? 'Duracion por revisar' : $duracionTotalLecciones . ' min')
            : 'Sin lecciones';
    @endphp
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div
            class="w-full rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">

            <div class="mb-6 rounded-[22px] border border-[#26352d] bg-gradient-to-r from-[#101612] to-[#10351f] p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-400">
                            Modulo educativo
                        </p>

                        <h1 class="mt-1 text-3xl font-bold tracking-tight text-white">
                            {{ $modulo->titulo }}
                        </h1>

                        <p class="mt-1 text-sm text-gray-400">
                            @if($esAdmin)
                                Gestiona las lecciones asociadas a este modulo. La duracion se calcula con la suma de sus lecciones.
                            @else
                                Revisa las lecciones disponibles y continua aprendiendo a tu ritmo.
                            @endif
                        </p>

                        @if($esAdmin && $duracionesPorRevisar > 0)
                        <p class="mt-2 text-sm text-yellow-300">
                            Hay {{ $duracionesPorRevisar }} leccion{{ $duracionesPorRevisar === 1 ? '' : 'es' }} con duracion fuera del rango permitido. Editala para corregir el total.
                        </p>
                        @endif

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <span
                                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                                {{ ucfirst($modulo->nivel) }}
                            </span>

                            <span
                                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                                {{ $duracionModuloTexto }}
                            </span>

                            <span
                                class="rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">
                                {{ $lecciones->count() }} lecciones
                            </span>
                        </div>
                    </div>

                    <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2 md:w-auto">
                        <a href="{{ route('educacion.index') }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/[0.06]">
                            <i class="bi bi-arrow-left"></i>
                            <span>Volver</span>
                        </a>

                        @if($esAdmin)
                        <a href="{{ route('modulos-educativos.lecciones.create', ['modulo' => $modulo->id_modulo]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#72f59a] px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                            <i class="bi bi-plus-lg"></i>
                            <span>Nueva leccion</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            @if($lecciones->isEmpty())
            <div class="rounded-[22px] border border-[#26352d] bg-[#111714] p-10 text-center">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-green-500/20 bg-green-500/10 text-green-400">
                    <i class="bi bi-collection-play text-2xl"></i>
                </div>

                <h2 class="mt-4 text-xl font-semibold text-white">
                    @if($esAdmin)
                        No hay lecciones registradas
                    @else
                        Este modulo aun no tiene lecciones
                    @endif
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    @if($esAdmin)
                        Anade la primera leccion para que este modulo tenga contenido.
                    @else
                        Vuelve mas tarde para continuar con este contenido.
                    @endif
                </p>
            </div>
            @else
            <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                @foreach($lecciones as $leccion)
                <div
                    class="rounded-[22px] border border-[#26352d] bg-[#111714] p-5 shadow-[0_0_30px_rgba(35,190,110,0.08)]">
                    <div class="mb-4 flex items-start justify-between gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl border border-green-500/20 bg-green-500/10 text-green-400">
                            <i class="bi bi-play-circle text-xl"></i>
                        </div>

                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                            {{ $leccion->duracion_minutos >= 1 && $leccion->duracion_minutos <= 180 ? $leccion->duracion_minutos . ' min' : 'Duracion por revisar' }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-white">
                        {{ $leccion->titulo }}
                    </h2>

                    <div
                        class="mt-4 rounded-xl border border-[#26352d] bg-[#1b201d] p-4 text-sm leading-relaxed text-gray-300">
                        {{ \Illuminate\Support\Str::limit($leccion->contenido, 180) }}
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        <a href="{{ route('modulos-educativos.lecciones.show', ['modulo' => $modulo->id_modulo, 'leccion' => $leccion->id_leccion]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/[0.06]">
                            <i class="bi bi-play-circle"></i>
                            <span>Ver / repasar</span>
                        </a>

                        @if($esAdmin)
                        <a href="{{ route('modulos-educativos.lecciones.edit', ['modulo' => $modulo->id_modulo, 'leccion' => $leccion->id_leccion]) }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-semibold text-green-400 transition hover:bg-green-500/20">
                            <i class="bi bi-pencil-square"></i>
                            <span>Editar</span>
                        </a>

                        <button type="button"
                            onclick="openDeleteModal('deleteModal-leccion-{{ $leccion->id_leccion }}')"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/20">
                            <i class="bi bi-trash3"></i>
                            <span>Eliminar</span>
                        </button>
                        @endif
                    </div>

                    @if($esAdmin)
                    <x-delete-modal id="deleteModal-leccion-{{ $leccion->id_leccion }}" title="Eliminar leccion?"
                        message="Esta leccion se eliminara permanentemente. Esta operacion es irreversible."
                        :action="route('modulos-educativos.lecciones.destroy', ['modulo' => $modulo->id_modulo, 'leccion' => $leccion->id_leccion])"
                        method="DELETE" />
                    @endif
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
