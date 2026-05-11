@php
    use App\Helpers\PresupuestoHelper;

    $meses = PresupuestoHelper::meses();
@endphp

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
                <span class="text-gray-300">Ingreso real</span>
                <span class="font-semibold text-[#72f59a]">
                    {{ number_format($ingresoReal, 2, ',', '.') }}€
                </span>
            </div>
        @endif

     <a href="{{ route('presupuestos.create') }}"
        class="budget-btn-primary inline-flex items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            Crear Presupuesto
        </a>
    </div>
</div>