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
                           class="inline-flex items-center gap-2 rounded-2xl border border-green-400/20 bg-[#63d38a] px-5 py-3 text-sm font-semibold text-black shadow-[0_0_20px_rgba(114,245,154,0.18)] transition hover:scale-[1.01] hover:bg-[#72f59a]">
                            <i class="bi bi-plus-lg text-sm"></i>
                            <span>Nueva Meta</span>
                        </a>
                    </div>
                </div>

                @include('metas.partials.resumen')
                @include('metas.partials.metas-activas')
                @include('metas.partials.metas-pausadas')
                @include('metas.partials.metas-completadas')
                @include('metas.partials.logros')

            </div>
        </div>
    </div>
</x-app-layout>