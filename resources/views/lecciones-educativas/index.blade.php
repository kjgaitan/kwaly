<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div
            class="w-full rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">

            <div class="mb-6 rounded-[22px] border border-[#26352d] bg-gradient-to-r from-[#101612] to-[#10351f] p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-400">
                            Módulo educativo
                        </p>

                        <h1 class="mt-1 text-3xl font-bold tracking-tight text-white">
                            {{ $modulo->titulo }}
                        </h1>

                        <p class="mt-1 text-sm text-gray-400">
                            Gestiona las lecciones asociadas a este módulo.
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <span
                                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                                {{ ucfirst($modulo->nivel) }}
                            </span>

                            <span
                                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                                {{ $modulo->duracion_minutos }} min
                            </span>

                            <span
                                class="rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">
                                {{ $lecciones->count() }} lecciones
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('modulos-educativos.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/[0.06]">
                            <i class="bi bi-arrow-left"></i>
                            <span>Volver</span>
                        </a>

                        <a href="{{ route('modulos-educativos.lecciones.create', $modulo->id_modulo) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#72f59a] px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                            <i class="bi bi-plus-lg"></i>
                            <span>Nueva lección</span>
                        </a>
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
                    No hay lecciones registradas
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Añade la primera lección para que este módulo tenga contenido.
                </p>

                <a href="{{ route('modulos-educativos.lecciones.create', $modulo->id_modulo) }}"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-[#72f59a] px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                    <i class="bi bi-plus-lg"></i>
                    <span>Crear primera lección</span>
                </a>
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
                            {{ $leccion->duracion_minutos }} min
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-white">
                        {{ $leccion->titulo }}
                    </h2>

                    <div
                        class="mt-4 rounded-xl border border-[#26352d] bg-[#1b201d] p-4 text-sm leading-relaxed text-gray-300">
                        {{ \Illuminate\Support\Str::limit($leccion->contenido, 180) }}
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <a href="{{ route('modulos-educativos.lecciones.edit', [$modulo->id_modulo, $leccion->id_leccion]) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-semibold text-green-400 transition hover:bg-green-500/20">
                            <i class="bi bi-pencil-square"></i>
                            <span>Editar</span>
                        </a>

                        <button type="button"
                            onclick="openDeleteModal('deleteModal-leccion-{{ $leccion->id_leccion }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/20">
                            <i class="bi bi-trash3"></i>
                            <span>Eliminar</span>
                        </button>
                    </div>

                    <x-delete-modal id="deleteModal-leccion-{{ $leccion->id_leccion }}" title="¿Eliminar lección?"
                        message="Esta lección se eliminará permanentemente. Esta operación es irreversible."
                        :action="route('modulos-educativos.lecciones.destroy', [$modulo->id_modulo, $leccion->id_leccion])"
                        method="DELETE" />
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</x-app-layout>