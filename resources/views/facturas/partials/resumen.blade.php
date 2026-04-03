<div class="mb-6 grid grid-cols-1 gap-4 xl:grid-cols-4">

    {{-- Pendiente --}}
    <div class="rounded-[22px] border border-[#244131] bg-[#1b201d] p-5 shadow-[0_0_30px_rgba(35,190,110,0.12)]">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm text-gray-400">Pagos pendientes</p>
                <h2 class="mt-2 text-3xl font-bold text-white">
                    {{ number_format($totalPendiente, 2, ',', '.') }}€
                </h2>

                <div class="mt-3 flex items-center gap-2 text-sm text-gray-400">
                    <i class="bi bi-clock-history text-yellow-300"></i>
                    <span>{{ $cantidadPendientes }} pendientes</span>
                </div>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-yellow-500/20 bg-yellow-500/10 text-yellow-300">
                <i class="bi bi-hourglass-split text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Pagado --}}
    <div class="rounded-[22px] border border-[#244131] bg-[#1b201d] p-5 shadow-[0_0_30px_rgba(35,190,110,0.10)]">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm text-gray-400">Pagos realizados</p>
                <h2 class="mt-2 text-3xl font-bold text-white">
                    {{ number_format($totalPagado, 2, ',', '.') }}€
                </h2>

                <div class="mt-3 flex items-center gap-2 text-sm text-gray-400">
                    <i class="bi bi-check-circle text-emerald-300"></i>
                    <span>{{ $cantidadPagadas }} pagadas</span>
                </div>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-300">
                <i class="bi bi-wallet2 text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Total --}}
    <div class="rounded-[22px] border border-[#244131] bg-[#1b201d] p-5 shadow-[0_0_30px_rgba(35,190,110,0.10)]">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm text-gray-400">Importe total</p>
                <h2 class="mt-2 text-3xl font-bold text-white">
                    {{ number_format($totalGeneral, 2, ',', '.') }}€
                </h2>

                <div class="mt-3 flex items-center gap-2 text-sm text-gray-400">
                    <i class="bi bi-receipt text-[#72f59a]"></i>
                    <span>{{ $cantidadTotal }} facturas</span>
                </div>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-[#2e5a40] bg-[#1f2b24] text-[#72f59a]">
                <i class="bi bi-journal-text text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Progreso --}}
    <div class="rounded-[22px] border border-[#244131] bg-[#1b201d] p-5 shadow-[0_0_30px_rgba(35,190,110,0.10)]">
        <div class="flex items-start justify-between gap-4">
            <div class="w-full">
                <p class="text-sm text-gray-400">Progreso de pagos</p>
                <h2 class="mt-2 text-3xl font-bold text-white">
                    {{ number_format($porcentajePagado, 1, ',', '.') }}%
                </h2>

                <div class="mt-4 h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                    <div
                        class="h-full rounded-full bg-[#72f59a] transition-all duration-500"
                        style="width: {{ $porcentajePagado }}%;"
                    ></div>
                </div>

                <p class="mt-3 text-sm text-gray-400">
                    Porcentaje del importe total ya pagado.
                </p>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-500/10 text-blue-300">
                <i class="bi bi-bar-chart-line text-xl"></i>
            </div>
        </div>
    </div>

</div>