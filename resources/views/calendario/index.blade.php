<x-app-layout>
    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <div class="mb-6">
                <h2 class="text-3xl font-bold tracking-tight text-white">Calendario Financiero</h2>
                <p class="mt-1 text-sm text-gray-400">Visualiza tus ingresos y pagos programados</p>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-green-500/30 bg-[#1c221f] p-4">
                    <p class="text-sm text-gray-400">Ingresos previstos</p>
                    <p class="mt-2 text-2xl font-bold text-green-400">
                        {{ number_format($ingresosPrevistos, 2, ',', '.') }} €
                    </p>
                </div>

                <div class="rounded-2xl border border-red-500/30 bg-[#1c221f] p-4">
                    <p class="text-sm text-gray-400">Pagos previstos</p>
                    <p class="mt-2 text-2xl font-bold text-red-400">
                        {{ number_format($gastosPrevistos, 2, ',', '.') }} €
                    </p>
                </div>

                <div class="rounded-2xl border border-emerald-500/30 bg-[#1c221f] p-4">
                    <p class="text-sm text-gray-400">Balance previsto</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-400">
                        {{ number_format($balancePrevisto, 2, ',', '.') }} €
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-[#26352d] bg-[#1a1f1c] p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        {{ ucfirst($fecha->translatedFormat('F \d\e Y')) }}
                    </h3>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('calendario.index', ['mes' => $fecha->copy()->subMonth()->format('Y-m')]) }}"
                           class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#2d3a33] bg-[#171c19] text-gray-300 transition hover:border-green-500/40 hover:text-white">
                            ‹
                        </a>

                        <a href="{{ route('calendario.index', ['mes' => $fecha->copy()->addMonth()->format('Y-m')]) }}"
                           class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#2d3a33] bg-[#171c19] text-gray-300 transition hover:border-green-500/40 hover:text-white">
                            ›
                        </a>
                    </div>
                </div>

                <div class="mb-2 grid grid-cols-7 gap-2 text-center text-xs font-medium uppercase tracking-wide text-gray-500">
                    <div>Lun</div>
                    <div>Mar</div>
                    <div>Mié</div>
                    <div>Jue</div>
                    <div>Vie</div>
                    <div>Sáb</div>
                    <div>Dom</div>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @foreach ($dias as $dia)
                        <div class="min-h-[120px] rounded-xl border border-[#26352d] bg-[#171c19] p-2 {{ !$dia->isSameMonth($fecha) ? 'opacity-40' : '' }}">
                            <div class="mb-2 text-xs font-semibold text-gray-400">
                                {{ $dia->day }}
                            </div>

                            @if(isset($eventosPorDia))
                                @php
                                    $clave = $dia->format('Y-m-d');
                                    $eventos = $eventosPorDia[$clave] ?? [];
                                @endphp

                                @foreach($eventos as $evento)
                                    <div class="mb-1 truncate rounded-md px-2 py-1 text-[11px]
                                        @if(($evento['tipo'] ?? '') === 'ingreso')
                                            bg-green-500/15 text-green-300 border border-green-500/20
                                        @elseif(($evento['tipo'] ?? '') === 'gasto')
                                            bg-red-500/15 text-red-300 border border-red-500/20
                                        @else
                                            bg-blue-500/15 text-blue-300 border border-blue-500/20
                                        @endif">
                                        {{ $evento['titulo'] ?? 'Evento' }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-[#26352d] bg-[#1a1f1c] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                <h4 class="mb-4 text-sm font-semibold text-white">Leyenda</h4>

                <div class="flex flex-wrap gap-3">
                    <div class="inline-flex items-center gap-2 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-2 text-sm text-green-300">
                        <span class="h-3 w-3 rounded-full bg-green-400"></span>
                        Ingresos
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm text-red-300">
                        <span class="h-3 w-3 rounded-full bg-red-400"></span>
                        Gastos/Pagos
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-xl border border-blue-500/30 bg-blue-500/10 px-4 py-2 text-sm text-blue-300">
                        <span class="h-3 w-3 rounded-full bg-blue-400"></span>
                        Recordatorios
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-[#26352d] bg-[#1a1f1c] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-green-500/30 bg-green-500/10 text-lg font-bold text-green-400">
                        !
                    </div>

                    <div>
                        <h4 class="text-base font-semibold text-white">Consejo Financiero</h4>
                        <p class="mt-1 text-sm text-gray-400">
                            {{ $consejo }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>