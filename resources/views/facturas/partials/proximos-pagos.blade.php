@php
    function badgeEstado($estado) {
        return match($estado) {
            'pagado' => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/20',
            'vencido' => 'bg-red-500/15 text-red-300 border border-red-500/20',
            default => 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/20',
        };
    }

    function iconoEstado($estado) {
        return match($estado) {
            'pagado' => 'bi-check-circle',
            'vencido' => 'bi-exclamation-circle',
            default => 'bi-clock',
        };
    }

    function cardIconBg($estado) {
        return match($estado) {
            'pagado' => 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20',
            'vencido' => 'bg-red-500/10 text-red-300 border border-red-500/20',
            default => 'bg-yellow-500/10 text-yellow-300 border border-yellow-500/20',
        };
    }

    function iconoFactura($concepto) {
        $texto = strtolower($concepto);

        if (str_contains($texto, 'alquiler') || str_contains($texto, 'hipoteca')) {
            return 'bi-house-door';
        }

        if (str_contains($texto, 'electricidad') || str_contains($texto, 'luz')) {
            return 'bi-lightning-charge';
        }

        if (str_contains($texto, 'internet') || str_contains($texto, 'wifi')) {
            return 'bi-wifi';
        }

        if (str_contains($texto, 'netflix') || str_contains($texto, 'spotify') || str_contains($texto, 'suscripción')) {
            return 'bi-play-circle';
        }

        return 'bi-receipt';
    }
@endphp

<div class="space-y-3">
    <div class="mb-2 flex items-center justify-between gap-3">
        <h3 class="text-base font-semibold text-white">Próximos Pagos</h3>

        @if($cantidadTotal > 0)
            <span class="rounded-full border border-[#314238] px-3 py-1 text-xs font-medium text-gray-300">
                {{ $cantidadTotal }} registros
            </span>
        @endif
    </div>

    @forelse($facturas as $factura)
        <div class="rounded-[20px] border border-[#244131] bg-[#1b201d] px-4 py-4 shadow-[0_0_24px_rgba(35,190,110,0.10)] transition hover:border-[#2f6b4a]">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex min-w-0 items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ cardIconBg($factura->estado_visual) }}">
                        <i class="bi {{ iconoFactura($factura->concepto) }}"></i>
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="text-sm font-semibold text-white md:text-base">
                                {{ $factura->concepto }}
                            </h4>

                            <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-[10px] font-medium text-emerald-300">
                                {{ ucfirst($factura->frecuencia) }}
                            </span>
                        </div>

                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-400">
                            <span>{{ $factura->proveedor }}</span>
                            <span>•</span>
                            <span>Vence: {{ \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('d/m/Y') }}</span>

                            @if($factura->estado_visual === 'vencido')
                                <span>•</span>
                                <span class="font-medium text-red-400">Vencido</span>
                            @endif

                            @if($factura->fecha_pago)
                                <span>•</span>
                                <span>Pagado: {{ \Carbon\Carbon::parse($factura->fecha_pago)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-start gap-3 lg:items-end">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-white">{{ number_format($factura->monto_total, 2, ',', '.') }}€</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-medium {{ badgeEstado($factura->estado_visual) }}">
                            <i class="bi {{ iconoEstado($factura->estado_visual) }}"></i>
                            {{ ucfirst($factura->estado_visual) }}
                        </span>

                        @if($factura->estado_visual !== 'pagado')
                            <form action="{{ route('facturas.pagar', $factura->id_factura) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="rounded-full bg-[#72f59a] px-3 py-1.5 text-[11px] font-semibold text-[#0d1510] transition hover:brightness-110"
                                >
                                    Marcar pagado
                                </button>
                            </form>
                        @endif

                        <a
                            href="{{ route('facturas.show', $factura->id_factura) }}"
                            class="rounded-full border border-[#355140] px-3 py-1.5 text-[11px] font-semibold text-gray-300 transition hover:border-[#72f59a] hover:text-white"
                        >
                            Ver
                        </a>

                        <a
                            href="{{ route('facturas.edit', $factura->id_factura) }}"
                            class="rounded-full border border-[#355140] px-3 py-1.5 text-[11px] font-semibold text-gray-300 transition hover:border-[#72f59a] hover:text-white"
                        >
                            Editar
                        </a>

                        <form action="{{ route('facturas.destroy', $factura->id_factura) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?')">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="rounded-full border border-red-500/20 px-3 py-1.5 text-[11px] font-semibold text-red-300 transition hover:bg-red-500/10"
                            >
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="rounded-[20px] border border-[#244131] bg-[#1b201d] px-4 py-8 text-center shadow-[0_0_24px_rgba(35,190,110,0.10)]">
            <i class="bi bi-receipt text-3xl text-[#72f59a]"></i>
            <p class="mt-3 text-base font-semibold text-white">Aún no tienes facturas registradas</p>
            <p class="mt-1 text-sm text-gray-400">Empieza creando tu primera factura para controlar tus próximos pagos.</p>
        </div>
    @endforelse
</div>