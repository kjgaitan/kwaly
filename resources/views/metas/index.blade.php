<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                            Metas Financieras
                        </h1>
                        <p class="mt-1 text-sm text-gray-400">
                            Alcanza tus objetivos paso a paso
                        </p>
                    </div>

                    <div class="flex items-center">
                        <a href="{{ route('metas.create') }}"
                           class="inline-flex items-center gap-2 rounded-2xl border border-green-400/20 bg-[#63d38a] px-5 py-3 text-sm font-semibold text-white shadow-[0_0_20px_rgba(114,245,154,0.18)] transition hover:scale-[1.01] hover:bg-[#72f59a]">
                            <i class="bi bi-plus-lg text-sm"></i>
                            <span>Nueva Meta</span>
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-5 rounded-2xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                @include('metas.partials.resumen')
                @include('metas.partials.metas-activas')
                @include('metas.partials.logros')

                <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-5 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl border border-green-400/20 bg-green-500/10 text-[#72f59a]">
                            <i class="bi bi-trophy text-2xl"></i>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white">
                                Excelente progreso
                            </h3>

                            <p class="mt-1 text-sm text-gray-400">
                                Has completado
                                <span class="font-semibold text-[#72f59a]">{{ $resumen['metas_completadas'] ?? 0 }} metas</span>
                                este año. Cada paso te acerca más a tu libertad financiera.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>