<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">

            <div class="mb-5 rounded-[22px] border border-[#1d2a22] bg-[radial-gradient(circle_at_top_right,_rgba(38,180,91,0.16),_transparent_32%),linear-gradient(180deg,#0b100d_0%,#09100d_100%)] p-5">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                            Educacion Financiera
                        </h1>

                        <p class="mt-1 text-sm text-gray-400">
                            @if($esAdmin)
                                Crea modulos y lecciones guiadas para que el aprendizaje sea claro y medible.
                            @else
                                Aprende conceptos financieros paso a paso y guarda tu avance en cada leccion.
                            @endif
                        </p>

                        <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1.5 text-xs font-medium text-green-400">
                            <i class="bi bi-stars"></i>
                            <span>{{ $leccionesCompletadas }} de {{ $totalLecciones }} lecciones completadas</span>
                        </div>
                    </div>

                    @if($esAdmin)
                        <div class="flex flex-col items-end gap-3 sm:flex-row">
                            <a href="{{ route('modulos-educativos.create') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                                <i class="bi bi-plus-lg"></i>
                                <span>Crear modulo</span>
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            @include('educacion.partials.progreso')

            <div class="mt-5">
                @include('educacion.partials.lecciones')
            </div>

            <div class="mt-5">
                @include('educacion.partials.tips')
            </div>

        </div>
    </div>
</x-app-layout>
