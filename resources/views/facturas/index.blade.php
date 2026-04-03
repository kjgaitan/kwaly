<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">Facturas y Pagos</h1>
                        <p class="mt-1 text-sm text-gray-400">Gestiona tus pagos programados</p>
                    </div>

                    <a
                        href="{{ route('facturas.create') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#72f59a] px-4 py-2.5 text-sm font-semibold text-[#0d1510] shadow-[0_8px_20px_rgba(114,245,154,0.25)] transition hover:brightness-110"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Nueva Factura
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                @include('facturas.partials.resumen')

                @include('facturas.partials.proximos-pagos')

                @include('facturas.partials.recordatorio')

            </div>
        </div>
    </div>
</x-app-layout>