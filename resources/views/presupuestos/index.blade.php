<x-app-layout> 
    @php
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $presupuestoActual = $presupuestos->first();

        $ingresoMensual = $presupuestoActual?->ingreso_estimado ?? 0;
        $porcNecesidades = $presupuestoActual?->porcentaje_necesidades ?? 50;
        $porcDeseos = $presupuestoActual?->porcentaje_deseos ?? 30;
        $porcAhorro = $presupuestoActual?->porcentaje_ahorro ?? 20;

        $montoNecesidades = $ingresoMensual * ($porcNecesidades / 100);
        $montoDeseos = $ingresoMensual * ($porcDeseos / 100);
        $montoAhorro = $ingresoMensual * ($porcAhorro / 100);

        $detalles = $presupuestoActual?->detalles ?? collect();

        $gastadoNecesidades = 0;
        $gastadoDeseos = 0;
        $gastadoAhorro = 0;

        foreach ($detalles as $detalle) {
            $categoriaTexto = strtolower($detalle->categoria->nombre ?? '');

            if (str_contains($categoriaTexto, 'ahorro')) {
                $gastadoAhorro += $detalle->monto_gastado;
            } elseif (
                str_contains($categoriaTexto, 'ocio') ||
                str_contains($categoriaTexto, 'restaurante') ||
                str_contains($categoriaTexto, 'deseo')
            ) {
                $gastadoDeseos += $detalle->monto_gastado;
            } else {
                $gastadoNecesidades += $detalle->monto_gastado;
            }
        }

        $dispNecesidades = max($montoNecesidades - $gastadoNecesidades, 0);
        $dispDeseos = max($montoDeseos - $gastadoDeseos, 0);
        $dispAhorro = max($montoAhorro - $gastadoAhorro, 0);

        $porcentajeUsoNecesidades = $montoNecesidades > 0 ? min(($gastadoNecesidades / $montoNecesidades) * 100, 100) : 0;
        $porcentajeUsoDeseos = $montoDeseos > 0 ? min(($gastadoDeseos / $montoDeseos) * 100, 100) : 0;
        $porcentajeUsoAhorro = $montoAhorro > 0 ? min(($gastadoAhorro / $montoAhorro) * 100, 100) : 0;
    @endphp

    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <!-- HEADER -->
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Presupuestos</h2>
                    <p class="mt-1 text-sm text-gray-400">Sistema 50/30/20 y sobres personalizados</p>
                    @if($presupuestoActual)
                        <p class="mt-2 text-xs text-gray-500">
                            {{ $meses[$presupuestoActual->mes] ?? 'Mes desconocido' }} {{ $presupuestoActual->anio }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if($presupuestoActual)
                        <div class="inline-flex items-center gap-3 self-start rounded-full border border-[#2d6f4f] bg-[#1f3a2c] px-4 py-2 text-sm">
                            <span class="text-gray-300">Ingreso mensual</span>
                            <span class="font-semibold text-[#72f59a]">
                                {{ number_format($ingresoMensual, 2, ',', '.') }}€
                            </span>
                        </div>
                    @endif

                    <a href="{{ route('presupuestos.create') }}"
                       class="inline-flex items-center rounded-xl bg-[#72f59a] px-4 py-2 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                        + Crear Presupuesto
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$presupuestoActual)
                <div class="rounded-2xl border border-[#26352d] bg-[#111613] p-10 text-center">
                    <h3 class="mb-2 text-xl font-semibold text-white">No tienes presupuestos aún</h3>
                    <p class="mb-4 text-gray-400">Empieza creando tu primer presupuesto mensual</p>

                    <a href="{{ route('presupuestos.create') }}"
                       class="rounded-xl bg-[#72f59a] px-5 py-3 font-semibold text-black hover:bg-[#5ee38a]">
                        Crear Presupuesto
                    </a>
                </div>
            @else

                <!-- CARDS PRINCIPALES -->
                <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">

                    <!-- NECESIDADES -->
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="mb-5 flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                🏠
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold text-white">Necesidades</h3>
                        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcNecesidades, 0) }}% del ingreso</p>

                        <div class="mt-6">
                            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                                <span>Gastado</span>
                                <span>{{ number_format($gastadoNecesidades, 2, ',', '.') }}€ / {{ number_format($montoNecesidades, 2, ',', '.') }}€</span>
                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full bg-[#72f59a]" style="width: {{ $porcentajeUsoNecesidades }}%"></div>
                            </div>
                        </div>

                        <div class="mt-5 rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Disponible</span>
                                <span class="text-xl font-semibold text-[#72f59a]">{{ number_format($dispNecesidades, 2, ',', '.') }}€</span>
                            </div>
                        </div>
                    </div>

                    <!-- DESEOS -->
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="mb-5 flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                🛍
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold text-white">Deseos</h3>
                        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcDeseos, 0) }}% del ingreso</p>

                        <div class="mt-6">
                            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                                <span>Gastado</span>
                                <span>{{ number_format($gastadoDeseos, 2, ',', '.') }}€ / {{ number_format($montoDeseos, 2, ',', '.') }}€</span>
                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full bg-[#72f59a]" style="width: {{ $porcentajeUsoDeseos }}%"></div>
                            </div>
                        </div>

                        <div class="mt-5 rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Disponible</span>
                                <span class="text-xl font-semibold text-[#72f59a]">{{ number_format($dispDeseos, 2, ',', '.') }}€</span>
                            </div>
                        </div>
                    </div>

                    <!-- AHORRO -->
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="mb-5 flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                ☆
                            </div>

                            @if($porcentajeUsoAhorro >= 100)
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-500/10 text-yellow-400">
                                    ⚠
                                </div>
                            @endif
                        </div>

                        <h3 class="text-xl font-semibold text-white">Ahorro</h3>
                        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcAhorro, 0) }}% del ingreso</p>

                        <div class="mt-6">
                            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                                <span>Gastado</span>
                                <span>{{ number_format($gastadoAhorro, 2, ',', '.') }}€ / {{ number_format($montoAhorro, 2, ',', '.') }}€</span>
                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full {{ $porcentajeUsoAhorro >= 100 ? 'bg-yellow-400' : 'bg-[#72f59a]' }}" style="width: {{ $porcentajeUsoAhorro }}%"></div>
                            </div>
                        </div>

                        <div class="mt-5 rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Disponible</span>
                                <span class="text-xl font-semibold text-[#72f59a]">{{ number_format($dispAhorro, 2, ',', '.') }}€</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SOBRES -->
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-white">Sobres Personalizados</h3>
                        <p class="text-sm text-gray-400">Gestiona tus categorías específicas</p>
                    </div>

                    @if($presupuestoActual)
                        <a href="{{ route('presupuestos.sobres.create', $presupuestoActual->id_presupuesto) }}"
                        class="rounded-xl bg-[#72f59a] px-4 py-2 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                            + Crear Sobre
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @forelse($detalles as $detalle)
                        @php
                            $limite = (float) $detalle->limite_monto;
                            $gastado = (float) $detalle->monto_gastado;
                            $uso = $limite > 0 ? min(($gastado / $limite) * 100, 100) : 0;

                            $categoriaNombre = $detalle->categoria->nombre ?? 'Categoría';
                            $tipoCategoria = 'General';

                            $colorBarra = 'bg-[#72f59a]';
                            if ($uso >= 80 && $uso < 95) {
                                $colorBarra = 'bg-yellow-400';
                            } elseif ($uso >= 95) {
                                $colorBarra = 'bg-red-400';
                            }
                        @endphp

                        <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_18px_rgba(114,245,154,0.04)]">
                            <div class="mb-4 flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg text-[#72f59a]"></span>
                                        <div>
                                            <h4 class="font-semibold text-white">{{ $categoriaNombre }}</h4>
                                            <p class="text-xs text-gray-500">{{ $tipoCategoria }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm font-semibold text-white">{{ number_format($gastado, 2, ',', '.') }}€</p>
                                    <p class="text-xs text-gray-500">de {{ number_format($limite, 2, ',', '.') }}€</p>
                                </div>
                            </div>

                            <div class="mb-2 flex items-center justify-between text-xs text-gray-400">
                                <span>{{ number_format($uso, 0) }}% utilizado</span>
                                @if($uso >= 80)
                                    <span class="text-yellow-300">⚠ Cerca del límite</span>
                                @endif
                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full {{ $colorBarra }}" style="width: {{ $uso }}%"></div>
                            </div>

                            @if($uso >= 80)
                                <div class="mt-4 rounded-xl border border-yellow-500/20 bg-yellow-500/5 px-4 py-3 text-sm text-yellow-300">
                                    ⚠ Has gastado el {{ number_format($uso, 0) }}% del presupuesto de {{ strtolower($categoriaNombre) }} este mes.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="xl:col-span-2 rounded-2xl border border-[#26352d] bg-[#111613] p-8 text-center">
                            <p class="text-lg font-semibold text-white">No hay sobres personalizados</p>
                            <p class="mt-2 text-sm text-gray-400">Aún no has añadido categorías al presupuesto actual.</p>
                        </div>
                    @endforelse
                </div>

                <!-- BLOQUE INFORMATIVO -->
                <div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_18px_rgba(114,245,154,0.04)]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                            ⓘ
                        </div>

                        <div>
                            <h4 class="font-semibold text-white">Sistema de Presupuesto 50/30/20</h4>
                            <p class="mt-1 text-sm text-gray-400">
                                Divide tus ingresos en 50% necesidades, 30% deseos, 20% ahorro.
                                Este método te ayudará a mantener un equilibrio financiero saludable y alcanzar tus metas de forma sostenible.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- LISTA DE PRESUPUESTOS CREADOS -->
                <div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-5">
                    <h3 class="mb-4 text-xl font-semibold text-white">Presupuestos creados</h3>

                    <div class="grid gap-4">
                        @foreach($presupuestos as $presupuesto)
                            <div class="rounded-2xl border border-[#26352d] bg-[#111613] p-4">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-white">
                                            {{ $meses[$presupuesto->mes] ?? 'Mes desconocido' }} {{ $presupuesto->anio }}
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-400">
                                            Ingreso estimado:
                                            <span class="font-semibold text-[#72f59a]">
                                                {{ number_format($presupuesto->ingreso_estimado, 2, ',', '.') }}€
                                            </span>
                                        </p>
                                        <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-400">
                                            <span>Necesidades: {{ $presupuesto->porcentaje_necesidades }}%</span>
                                            <span>Deseos: {{ $presupuesto->porcentaje_deseos }}%</span>
                                            <span>Ahorro: {{ $presupuesto->porcentaje_ahorro }}%</span>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('presupuestos.edit', $presupuesto->id_presupuesto) }}"
                                           class="rounded-lg border border-[#26352d] px-4 py-2 text-sm text-white hover:bg-[#1a211d]">
                                            Editar
                                        </a>

                                        <form action="{{ route('presupuestos.destroy', $presupuesto->id_presupuesto) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Eliminar este presupuesto?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg bg-red-500 px-4 py-2 text-sm text-white hover:bg-red-600">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>