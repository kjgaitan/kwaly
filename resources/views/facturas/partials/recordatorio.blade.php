@php
    $mensajeRecordatorio = 'Todo está bajo control.';

    if ($cantidadPendientes > 0 && $totalPendiente > 0) {
        $mensajeRecordatorio = 'Recuerda revisar tus vencimientos próximos para evitar retrasos y mantener tu control financiero al día.';
    }

    if ($cantidadPendientes > 0 && $cantidadPagadas === 0) {
        $mensajeRecordatorio = 'Aún no has marcado pagos como completados. Intenta mantener tus registros actualizados para que tus reportes sean más precisos.';
    }

    if ($cantidadPendientes === 0 && $cantidadTotal > 0) {
        $mensajeRecordatorio = 'Excelente trabajo. No tienes pagos pendientes en este momento.';
    }
@endphp

<div class="mt-5 rounded-[20px] border border-[#244131] bg-[#1b201d] px-4 py-4 shadow-[0_0_24px_rgba(35,190,110,0.10)]">
    <div class="flex items-start gap-3">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-500/10 text-blue-300">
            <i class="bi bi-info-circle"></i>
        </div>

        <div class="w-full">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <h4 class="text-sm font-semibold text-white">Recordatorio</h4>

                @if($cantidadTotal > 0)
                    <span class="rounded-full border border-[#314238] px-3 py-1 text-[11px] font-medium text-gray-300">
                        {{ $cantidadPagadas }}/{{ $cantidadTotal }} pagadas
                    </span>
                @endif
            </div>

            <p class="mt-2 text-sm leading-6 text-gray-400">
                @if($cantidadTotal === 0)
                    No hay registros de facturas. Añade tu primera factura para empezar a controlar pagos, vencimientos y reportes.
                @else
                    Tienes
                    <span class="font-semibold text-white">{{ $cantidadPendientes }} pagos pendientes</span>
                    por un total de
                    <span class="font-semibold text-[#72f59a]">{{ number_format($totalPendiente, 2, ',', '.') }}€</span>.
                    {{ $mensajeRecordatorio }}
                @endif
            </p>
        </div>
    </div>
</div>