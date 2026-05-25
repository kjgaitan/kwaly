<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5" x-data="{ futureFeatureModalOpen: false }" @keydown.escape.window="futureFeatureModalOpen = false">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">Facturas y Pagos</h1>
                        <p class="mt-1 text-sm text-gray-400">Gestiona tus pagos programados</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-xl border border-[#26352d] bg-[#72f59a] px-3 py-2.5 text-sm font-semibold text-black transition hover:brightness-110"
                            aria-label="Escanear facturas (próximamente)"
                            title="Próximamente"
                            @click="futureFeatureModalOpen = true"
                        >
                            <i class="bi bi-upc-scan"></i>
                        </button>

                        <a
                            href="{{ route('facturas.create') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#72f59a] px-4 py-2.5 text-sm font-semibold text-[#0d1510] shadow-[0_8px_20px_rgba(114,245,154,0.25)] transition hover:brightness-110"
                        >
                            <i class="bi bi-plus-lg"></i>
                            Nueva Factura
                        </a>
                    </div>
                </div>

                @include('facturas.partials.resumen')

                @include('facturas.partials.proximos-pagos')

                @include('facturas.partials.recordatorio')

            </div>
        </div>

        <div
            x-cloak
            x-show="futureFeatureModalOpen"
            class="fixed inset-0 z-[60] flex items-center justify-center px-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="facturasFutureFeatureModalLabel"
        >
            <div class="absolute inset-0 bg-black/70" @click="futureFeatureModalOpen = false"></div>

            <div
                x-show="futureFeatureModalOpen"
                x-transition
                class="relative w-full max-w-md rounded-2xl border border-[#26352d] bg-[#171c19] shadow-[0_0_24px_rgba(0,0,0,0.55)]"
            >
                <div class="flex items-center justify-between border-b border-[#26352d] px-5 py-4">
                    <h2 class="text-lg font-semibold text-white" id="facturasFutureFeatureModalLabel">Funcionalidad futura</h2>
                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#26352d] bg-[#0f1412] text-white transition hover:bg-[#1a211d]"
                        aria-label="Cerrar"
                        @click="futureFeatureModalOpen = false"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="px-5 py-4 text-sm text-gray-300">
                    Esta funcionalidad (escanear facturas) estará disponible en una próxima actualización.
                </div>

                <div class="flex justify-end gap-3 border-t border-[#26352d] px-5 py-4">
                    <button
                        type="button"
                        class="inline-flex items-center rounded-xl bg-[#72f59a] px-4 py-2 text-sm font-semibold text-[#0d1510] transition hover:brightness-110"
                        @click="futureFeatureModalOpen = false"
                    >
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>