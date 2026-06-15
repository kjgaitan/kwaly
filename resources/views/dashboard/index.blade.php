@php
    $money = fn ($value) => number_format((float) $value, 2, ',', '.') . '€';
    $signedMoney = fn ($value) => ((float) $value >= 0 ? '+' : '-') . $money(abs((float) $value));
    $balanceColor = $balance >= 0 ? 'text-[#8bffab]' : 'text-red-400';
    $variacion = $tendenciaMensual['variacion'] ?? 0;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
                        <p class="mt-1 text-sm text-gray-400">Resumen real de tu actividad financiera</p>
                    </div>

                    <div class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2 text-sm text-gray-300">
                        {{ now()->translatedFormat('F Y') }}
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Ingresos del Mes</p>
                                <h3 class="mt-1 text-2xl font-bold text-[#72f59a]">{{ $money($ingresosMes) }}</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#72f59a]/15 text-[#72f59a] shadow-[0_0_18px_rgba(114,245,154,0.18)]">
                                <i class="bi bi-arrow-up text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(255,80,80,0.04)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Gastos del Mes</p>
                                <h3 class="mt-1 text-2xl font-bold text-red-400">{{ $money($gastosMes) }}</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-400/15 text-lg text-red-400 shadow-[0_0_18px_rgba(248,113,113,0.16)]">
                                <i class="bi bi-arrow-down text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Balance Disponible</p>
                                <h3 class="mt-1 text-2xl font-bold {{ $balanceColor }}">{{ $money($balance) }}</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#72f59a]/15 text-lg text-[#8bffab] shadow-[0_0_18px_rgba(114,245,154,0.14)]">
                                <i class="bi bi-wallet2 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                            <i class="bi bi-lightbulb text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold">¿Vas por buen camino?</h3>
                            <p class="text-sm text-gray-400">
                                Este mes llevas
                                <span class="font-semibold text-[#72f59a]">{{ $money($ingresosMes) }}</span>
                                en ingresos y
                                <span class="font-semibold text-red-400">{{ $money($gastosMes) }}</span>
                                en gastos. Tu balance actual es
                                <span class="font-semibold {{ $balanceColor }}">{{ $money($balance) }}</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-1 gap-4 xl:grid-cols-2">
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <h3 class="mb-4 text-base font-semibold">Gastos por Categoría</h3>

                        <div class="mb-5 flex justify-center">
                            <div class="relative flex h-44 w-44 items-center justify-center rounded-full shadow-[0_0_26px_rgba(114,245,154,0.14)]"
                                 style="background: {{ $gastosPorCategoria['gradiente'] }}">
                                <div class="flex h-24 w-24 flex-col items-center justify-center rounded-full border border-[#26352d] bg-[#171c19]">
                                    <span class="text-xl font-bold text-[#72f59a]">{{ $money($gastosPorCategoria['total']) }}</span>
                                    <span class="text-[11px] text-gray-400">Total</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            @forelse($gastosPorCategoria['categorias'] as $categoria)
                                <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                    <div class="flex items-center gap-3">
                                        <span class="h-3 w-3 rounded-full" style="background-color: {{ $categoria['color'] }}"></span>
                                        <span class="text-sm">{{ $categoria['nombre'] }}</span>
                                    </div>
                                    <span class="text-sm text-gray-300">
                                        {{ number_format($categoria['porcentaje'], 1, ',', '.') }}% · {{ $money($categoria['total']) }}
                                    </span>
                                </div>
                            @empty
                                <div class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-6 text-center text-sm text-gray-400">
                                    Todavía no hay gastos registrados este mes.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="mb-4 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-base font-semibold">Tendencia Mensual</h3>
                                <p class="text-sm text-gray-400">Balance del mes actual</p>
                                <h4 class="mt-1 text-2xl font-bold text-white">{{ $money($tendenciaMensual['balanceActual']) }}</h4>
                                <span class="mt-2 inline-block rounded-full {{ $variacion >= 0 ? 'bg-[#72f59a]/15 text-[#72f59a]' : 'bg-red-400/15 text-red-400' }} px-3 py-1 text-xs font-semibold">
                                    {{ $variacion >= 0 ? '+' : '' }}{{ number_format($variacion, 1, ',', '.') }}%
                                </span>
                                <span class="ml-2 text-xs text-gray-400">vs mes anterior</span>
                            </div>

                            <div class="text-right">
                                <p class="text-[11px] text-gray-500">Actualizado</p>
                                <p class="text-sm text-gray-300">{{ now()->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="relative h-64 overflow-hidden rounded-2xl border border-[#26352d] bg-[#111613]">
                            <div class="absolute inset-0 flex flex-col justify-between p-5">
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                            </div>

                            <svg class="absolute inset-0 h-full w-full" viewBox="0 0 600 300" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="lineFill" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#72f59a" stop-opacity="0.30" />
                                        <stop offset="100%" stop-color="#72f59a" stop-opacity="0" />
                                    </linearGradient>
                                </defs>

                                <path d="{{ $tendenciaMensual['path']['relleno'] }}" fill="url(#lineFill)" />
                                <path d="{{ $tendenciaMensual['path']['linea'] }}" fill="none" stroke="#72f59a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <div class="absolute bottom-4 left-0 right-0 flex justify-between px-5 text-[11px] text-gray-400">
                                @foreach($tendenciaMensual['meses'] as $mes)
                                    <span>{{ $mes['etiqueta'] }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_22px_rgba(114,245,154,0.06)]">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold">Sistema presupuestario</h3>
                        <a href="{{ route('presupuestos.index') }}" class="text-sm text-[#72f59a] hover:underline">Ver presupuestos</a>
                    </div>

                    @if($presupuestoDashboard['existe'])
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            @foreach($presupuestoDashboard['items'] as $item)
                                <div>
                                    <div class="mb-2 flex items-center justify-between text-sm">
                                        <span class="text-white">{{ $item['etiqueta'] }}</span>
                                        <span class="font-semibold text-[#72f59a]">{{ number_format($item['uso'], 0, ',', '.') }}%</span>
                                    </div>
                                    <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                        <div class="h-full rounded-full bg-[#72f59a] shadow-[0_0_12px_rgba(114,245,154,0.22)]"
                                             style="width: {{ $item['uso'] }}%"></div>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-400">
                                        {{ $money($item['gastado']) }} de {{ $money($item['limite']) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-6 text-center text-sm text-gray-400">
                            No hay presupuesto creado para {{ now()->translatedFormat('F Y') }}.
                        </div>
                    @endif
                </div>

                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_22px_rgba(114,245,154,0.05)]">
                    <h3 class="mb-4 text-base font-semibold">Tus Logros Financieros</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        @forelse($logrosDashboard as $logro)
                            <div class="rounded-2xl border border-[#26352d] bg-[#1b211d] p-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                        <i class="bi {{ $logro['icono'] }} text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">{{ $logro['titulo'] }}</h4>
                                        <p class="text-sm text-gray-400">{{ $logro['descripcion'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-[#26352d] bg-[#1b211d] p-4 md:col-span-3">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-200/10 text-gray-300">
                                        <i class="bi bi-graph-up-arrow text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">Sin logros del mes todavía</h4>
                                        <p class="text-sm text-gray-400">Cuando tus datos cumplan un hito financiero, aparecerá aquí.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_22px_rgba(114,245,154,0.05)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-base font-semibold">Transacciones Recientes</h3>
                        <a href="{{ route('transacciones.index') }}" class="text-sm text-[#72f59a] hover:underline">Ver todas</a>
                    </div>

                    <div class="space-y-2.5">
                        @forelse($ultimasTransacciones as $transaccion)
                            @php
                                $esIngreso = $transaccion->tipo_movimiento === 'ingreso';
                            @endphp
                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $esIngreso ? 'bg-[#72f59a]/15 text-[#72f59a]' : 'bg-red-400/15 text-red-400' }}">
                                        <i class="bi {{ $esIngreso ? 'bi-arrow-up' : 'bi-arrow-down' }} text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $transaccion->titulo }}</p>
                                        <p class="text-sm text-gray-400">{{ optional($transaccion->categoria)->nombre ?? 'Sin categoria' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold {{ $esIngreso ? 'text-[#72f59a]' : 'text-red-400' }}">
                                        {{ $signedMoney($esIngreso ? $transaccion->monto : -$transaccion->monto) }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $transaccion->fecha_transaccion->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-6 text-center text-sm text-gray-400">
                                No hay transacciones registradas todavía.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
