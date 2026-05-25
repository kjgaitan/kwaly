<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div
            class="w-full rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">

            <div class="mb-6 rounded-[22px] border border-[#26352d] bg-gradient-to-r from-[#101612] to-[#10351f] p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">
                            Educación Financiera
                        </h1>

                        <p class="mt-1 text-sm text-gray-400">
                            Aprende a gestionar mejor tu dinero
                        </p>

                        <div
                            class="mt-4 inline-flex items-center gap-2 rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">
                            <i class="bi bi-stars"></i>
                            <span>{{ $modulos->count() }} módulos disponibles</span>
                        </div>
                    </div>

                    <a href="{{ route('modulos-educativos.create') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#72f59a] px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                        <i class="bi bi-plus-lg"></i>
                        <span>Crear módulo</span>
                    </a>
                </div>
            </div>

            <div class="mb-6 rounded-[20px] border border-[#26352d] bg-[#111714] p-4">
                <div class="mb-3 flex items-center justify-between">
                    <span class="text-sm font-semibold text-white">
                        Tu Progreso de Aprendizaje
                    </span>

                    <span class="text-sm font-bold text-[#72f59a]">
                        0%
                    </span>
                </div>

                <div class="h-2 rounded-full bg-[#202421]">
                    <div class="h-full rounded-full bg-[#72f59a]" style="width: 0%"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
                @forelse($modulos as $modulo)
                @php
                $iconos = [
                'basico' => 'bi-bookmark-heart',
                'intermedio' => 'bi-lightbulb',
                'avanzado' => 'bi-graph-up-arrow',
                ];

                $icono = $iconos[$modulo->nivel] ?? 'bi-bookmark-heart';
                $totalLecciones = $modulo->lecciones_count ?? 0;
                @endphp

                <div
                    class="rounded-[22px] border border-[#26352d] bg-[#111714] p-5 shadow-[0_0_30px_rgba(35,190,110,0.08)]">
                    <div class="mb-5 flex items-start justify-between">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl border border-green-500/20 bg-green-500/10 text-green-400 shadow-[0_0_24px_rgba(114,245,154,0.25)]">
                            <i class="bi {{ $icono }} text-xl"></i>
                        </div>

                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-green-500/20 bg-green-500/10 text-green-400">
                            <i class="bi bi-arrow-repeat text-sm"></i>
                        </span>
                    </div>

                    <div class="mb-4 flex flex-wrap items-center gap-2">
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                            {{ ucfirst($modulo->nivel) }}
                        </span>

                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                            Duración por lecciones
                        </span>

                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                            {{ $totalLecciones }} lecciones
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-white">
                        {{ $modulo->titulo }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        {{ $modulo->descripcion }}
                    </p>

                    <div class="mt-5 rounded-xl border border-[#26352d] bg-[#1b201d] p-4 text-sm text-gray-300">
                        @if($totalLecciones > 0)
                        Este módulo contiene {{ $totalLecciones }} lección{{ $totalLecciones === 1 ? '' : 'es' }}
                        disponible{{ $totalLecciones === 1 ? '' : 's' }}.
                        @else
                        Este módulo todavía no tiene lecciones. Añade contenido desde “Gestionar lecciones”.
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-2 md:grid-cols-3">
                        <a href="{{ route('modulos-educativos.lecciones.index', ['modulo' => $modulo->id_modulo]) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#72f59a] px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                            <i class="bi bi-collection-play"></i>
                            <span>Lecciones</span>
                        </a>

                        <a href="{{ route('modulos-educativos.edit', ['modulo' => $modulo->id_modulo]) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-semibold text-green-400 transition hover:bg-green-500/20">
                            <i class="bi bi-pencil-square"></i>
                            <span>Editar</span>
                        </a>

                        <button type="button" onclick="openDeleteModal('deleteModal-modulo-{{ $modulo->id_modulo }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/20">
                            <i class="bi bi-trash3"></i>
                            <span>Eliminar</span>
                        </button>
                    </div>

                    <x-delete-modal id="deleteModal-modulo-{{ $modulo->id_modulo }}" title="¿Eliminar módulo educativo?"
                        message="Este módulo y sus lecciones asociadas se eliminarán permanentemente. Esta operación es irreversible."
                        :action="route('modulos-educativos.destroy', ['modulo' => $modulo->id_modulo])" method="DELETE" />
                </div>
                @empty
                <div class="xl:col-span-2 rounded-[22px] border border-[#26352d] bg-[#111714] p-8 text-center">
                    <p class="text-lg font-semibold text-white">
                        No hay módulos educativos registrados
                    </p>

                    <p class="mt-2 text-sm text-gray-400">
                        Crea el primer módulo para empezar a añadir lecciones.
                    </p>
                </div>
                @endforelse
            </div>

            <div class="mt-6 rounded-[22px] border border-[#26352d] bg-[#111714] p-5">
                <div class="mb-4 flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-green-500/20 bg-green-500/10 text-green-400">
                        <i class="bi bi-lightbulb"></i>
                    </div>

                    <h3 class="text-lg font-semibold text-white">
                        Tips Financieros Rápidos
                    </h3>
                </div>

                <div class="space-y-3">
                    @foreach([
                    'Paga primero tus ahorros, luego tus gastos',
                    'Evita las compras impulsivas esperando 24 horas',
                    'Revisa tus suscripciones cada 3 meses',
                    'Usa la regla de los 30 días para compras grandes',
                    'Negocia tus facturas recurrentes anualmente',
                    ] as $tip)
                    <div
                        class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#1b201d] px-4 py-3 text-sm text-gray-300">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-500/10 text-green-400">
                                <i class="bi bi-lightbulb text-xs"></i>
                            </span>

                            <span>{{ $tip }}</span>
                        </div>

                        <i class="bi bi-chevron-right text-gray-500"></i>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
