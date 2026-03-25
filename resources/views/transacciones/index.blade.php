<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <!-- HEADER -->
                <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Transacciones</h2>
                        <p class="mt-1 text-sm text-gray-400">Gestiona tus ingresos y gastos</p>
                    </div>

                    <a href="{{ route('transacciones.create') }}"
                       class="inline-flex rounded-xl bg-[#72f59a] px-4 py-2 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                        + Nueva Transacción
                    </a>
                </div>

                <!-- CARDS RESUMEN -->
                <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.06)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-gray-400">Total Ingresos</p>
                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    {{ number_format($totalIngresos, 2, ',', '.') }}€
                                </h3>
                            </div>
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#72f59a]/15 text-[#72f59a]">
                                ↑
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(255,80,80,0.05)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-gray-400">Total Gastos</p>
                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    {{ number_format($totalGastos, 2, ',', '.') }}€
                                </h3>
                            </div>
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-400/15 text-red-400">
                                ↓
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.06)]">
                        <div>
                            <p class="text-[11px] text-gray-400">Transacciones</p>
                            <h3 class="mt-2 text-2xl font-bold text-[#72f59a]">
                                {{ $totalTransacciones }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- FILTROS -->
            <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.04)]">
                <form method="GET" action="{{ route('transacciones.index') }}" id="filtroForm">
                    <div class="flex flex-col gap-3 md:flex-row">
                        <input
                            type="text"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar transacciones..."
                            oninput="clearTimeout(window.temporizadorBusqueda); window.temporizadorBusqueda = setTimeout(() => document.getElementById('filtroForm').submit(), 500);"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2 text-sm text-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#72f59a] md:max-w-xs"
                        >

                        <select
                            name="tipo"
                            onchange="document.getElementById('filtroForm').submit()"
                            class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a] md:w-36"
                        >
                            <option value="" {{ request('tipo') == '' ? 'selected' : '' }}>Todos</option>
                            <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                            <option value="gasto" {{ request('tipo') == 'gasto' ? 'selected' : '' }}>Gastos</option>
                        </select>
                    </div>
                </form>
            </div>

                <!-- LISTA DE TRANSACCIONES -->
                <div class="space-y-4">
                    @forelse ($transacciones as $transaccion)
                        @php
                            $esIngreso = $transaccion->tipo_movimiento === 'ingreso';
                            $colorImporte = $esIngreso ? 'text-[#55d98a]' : 'text-red-400';
                            $colorIcono = $esIngreso
                                ? 'border-[#2d6f4f] bg-[#1f3a2c] text-[#55d98a]'
                                : 'border-red-500/40 bg-red-500/10 text-red-400';

                            $simbolo = $esIngreso ? '↑' : '↓';
                            $categoria = $transaccion->categoria->nombre ?? 'Sin categoría';
                            $fecha = \Carbon\Carbon::parse($transaccion->fecha_transaccion)->translatedFormat('j \d\e F');
                        @endphp

                        <div class="rounded-[26px] border border-[#244332] bg-[#1c1f1d] px-6 py-6 shadow-[0_0_30px_rgba(49,196,120,0.16)]">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                                <!-- IZQUIERDA -->
                                <div class="flex min-w-0 items-center gap-6">
                                    <div class="flex h-[74px] w-[74px] items-center justify-center rounded-full border {{ $colorIcono }} text-[38px]">
                                        {{ $simbolo }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-[23px] font-semibold leading-none text-white">
                                            {{ $transaccion->titulo ?: 'Sin título' }}
                                        </p>

                                        <div class="mt-4 flex flex-wrap items-center gap-4">
                                            <span class="inline-flex rounded-full border border-[#2d6f4f] bg-[#1f3a2c] px-5 py-2 text-[18px] leading-none text-[#55d98a]">
                                                {{ $categoria }}
                                            </span>

                                            <span class="text-[18px] text-gray-400">
                                                {{ $fecha }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- DERECHA -->
                                <div class="flex flex-col items-start gap-4 lg:items-end">
                                    <div class="text-left lg:text-right">
                                        <p class="text-[28px] font-semibold {{ $colorImporte }}">
                                            {{ $esIngreso ? '+' : '-' }}{{ number_format($transaccion->monto, 2, ',', '.') }}€
                                        </p>
                                        <p class="mt-1 text-xs uppercase tracking-wide text-gray-500">EUR</p>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('transacciones.edit', $transaccion->id_transaccion) }}"
                                           class="rounded-xl border border-[#2d6f4f] bg-[#1f3a2c] px-4 py-2 text-sm font-medium text-[#55d98a] transition hover:bg-[#285239]">
                                            Editar
                                        </a>

                                        <form action="{{ route('transacciones.destroy', $transaccion->id_transaccion) }}" method="POST"
                                              onsubmit="return confirm('¿Seguro que quieres eliminar esta transacción?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm font-medium text-red-400 transition hover:bg-red-500/20">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[26px] border border-[#244332] bg-[#1c1f1d] px-6 py-10 text-center shadow-[0_0_30px_rgba(49,196,120,0.10)]">
                            <p class="text-lg font-semibold text-white">No hay transacciones registradas</p>
                            <p class="mt-2 text-sm text-gray-400">Cuando agregues movimientos, aparecerán aquí.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>