<div class="mb-8">
    <h2 class="mb-4 text-base font-semibold text-white">
        Metas Activas
    </h2>

    @if(isset($metasActivas) && $metasActivas->count() > 0)
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            @foreach ($metasActivas as $meta)
                <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-4 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
                    <div class="flex h-full flex-col gap-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-xl border border-green-400/20 bg-green-500/10 text-[#72f59a]">
                                    @php
                                        $icono = match($meta['prioridad'] ?? 'media') {
                                            'alta' => 'bi bi-airplane',
                                            'media' => 'bi bi-shield',
                                            'baja' => 'bi bi-laptop',
                                            default => 'bi bi-bullseye'
                                        };
                                    @endphp
                                    <i class="{{ $icono }} text-2xl"></i>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $meta['titulo'] }}
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $meta['fecha_limite'] ?? 'Sin fecha límite' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if(($meta['completada'] ?? false) === true)
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/15 text-[#72f59a]">
                                        <i class="bi bi-trophy"></i>
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-xs font-medium text-gray-300">
                                        {{ ucfirst($meta['prioridad'] ?? 'media') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-bold tracking-tight text-white">
                                    {{ number_format($meta['monto_actual'] ?? 0, 0, ',', '.') }}€
                                </p>

                                @if(($meta['faltante'] ?? 0) > 0)
                                    <p class="mt-2 flex items-center gap-2 text-sm text-gray-400">
                                        <i class="bi bi-lightning-charge-fill text-[#72f59a]"></i>
                                        Faltan {{ number_format($meta['faltante'], 0, ',', '.') }}€
                                    </p>
                                @else
                                    <p class="mt-2 flex items-center gap-2 text-sm text-[#72f59a]">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Meta completada
                                    </p>
                                @endif
                            </div>

                            <div class="text-right text-sm text-gray-400">
                                / {{ number_format($meta['monto_objetivo'] ?? 0, 0, ',', '.') }}€
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-xs font-semibold text-[#72f59a]">
                                    {{ number_format($meta['progreso'] ?? 0, 0) }}%
                                </span>

                                @if(!is_null($meta['dias_restantes'] ?? null))
                                    <span class="text-xs text-gray-400">
                                        @if(($meta['dias_restantes'] ?? 0) >= 0)
                                            {{ $meta['dias_restantes'] }} días restantes
                                        @else
                                            Vencida
                                        @endif
                                    </span>
                                @endif
                            </div>

                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#2a2d2f]">
                                <div class="h-full rounded-full bg-[#72f59a] transition-all duration-500"
                                     style="width: {{ min($meta['progreso'] ?? 0, 100) }}%;">
                                </div>
                            </div>
                        </div>

                        @if(($meta['completada'] ?? false) === true)
                            <div class="rounded-xl border border-green-400/20 bg-gradient-to-r from-green-500/25 to-green-400/10 px-4 py-3 text-center text-sm font-semibold text-green-200">
                                Felicidades - Alcanzaste tu meta
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-white/10 bg-[#1b1b1d] px-6 py-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-green-500/10 text-[#72f59a]">
                <i class="bi bi-bullseye text-3xl"></i>
            </div>

            <h3 class="text-lg font-semibold text-white">
                Aún no tienes metas activas
            </h3>

            <p class="mt-2 text-sm text-gray-400">
                Empieza creando tu primera meta financiera para seguir tu progreso.
            </p>

            <a href="{{ route('metas.create') }}"
               class="mt-5 inline-flex items-center gap-2 rounded-2xl border border-green-400/20 bg-[#63d38a] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#72f59a]">
                <i class="bi bi-plus-lg"></i>
                Crear primera meta
            </a>
        </div>
    @endif
</div>