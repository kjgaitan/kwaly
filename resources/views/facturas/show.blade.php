<x-app-layout>
    @php
        $estadoVisual = $factura->estado;

        if ($factura->estado !== 'pagada' && $factura->fecha_vencimiento < now()->toDateString()) {
            $estadoVisual = 'vencida';
        }

        $claseEstado = match($estadoVisual) {
            'pagada' => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/20',
            'vencida' => 'bg-red-500/15 text-red-300 border border-red-500/20',
            default => 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/20',
        };
    @endphp

    <div class="mx-auto max-w-4xl">
        <div class="rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="border-b border-[#26352d] px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Detalle de Factura</h1>
                <p class="mt-1 text-sm text-gray-400">Consulta la información completa de esta factura.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 px-6 py-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-400">Proveedor</p>
                    <p class="mt-1 text-base font-medium text-white">{{ $factura->proveedor }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Concepto</p>
                    <p class="mt-1 text-base font-medium text-white">{{ $factura->concepto }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-400">Descripción</p>
                    <p class="mt-1 text-base font-medium text-white">
                        {{ $factura->descripcion ?: 'Sin descripción' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Monto total</p>
                    <p class="mt-1 text-base font-medium text-white">{{ number_format($factura->monto_total, 2, ',', '.') }}€</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Fecha de vencimiento</p>
                    <p class="mt-1 text-base font-medium text-white">
                        {{ \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Fecha de pago</p>
                    <p class="mt-1 text-base font-medium text-white">
                        {{ $factura->fecha_pago ? \Carbon\Carbon::parse($factura->fecha_pago)->format('d/m/Y') : 'Aún no pagada' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Frecuencia</p>
                    <p class="mt-1 text-base font-medium text-white">{{ ucfirst($factura->frecuencia) }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-400">Estado</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $claseEstado }}">
                            {{ ucfirst($estadoVisual) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-[#26352d] px-6 py-5">
                <a
                    href="{{ route('facturas.edit', $factura->id_factura) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-[#0d1510] transition hover:brightness-110"
                >
                    Editar factura
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
