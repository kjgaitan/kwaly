<div class="mb-4 flex items-center justify-between">
    <div>
        <h3 class="text-xl font-semibold text-white">Sobres Personalizados</h3>
        <p class="text-sm text-gray-400">Gestiona tus categorías específicas</p>
    </div>

    @if($presupuestoActual)
        <a href="{{ route('presupuestos.sobres.create', $presupuestoActual->id_presupuesto) }}"
           class="budget-btn-primary">
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
            $tipoCategoria = ucfirst($detalle->categoria->tipo_categoria ?? 'General');
            $colorBarra = \App\Helpers\PresupuestoHelper::colorUsoSobre($uso);
        @endphp

        <div class="budget-panel">
            <div class="mb-4 flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-lg text-[#72f59a]">●</span>
                    <div>
                        <h4 class="font-semibold text-white">{{ $categoriaNombre }}</h4>
                        <p class="text-xs text-gray-500">{{ $tipoCategoria }}</p>
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

            <div class="budget-progress-track">
                <div class="h-full rounded-full {{ $colorBarra }}" style="width: {{ $uso }}%"></div>
            </div>

            @if($uso >= 80)
                <div class="budget-alert-warning">
                    ⚠ Has gastado el {{ number_format($uso, 0) }}% del presupuesto de {{ strtolower($categoriaNombre) }} este mes.
                </div>
            @endif
        </div>
    @empty
        <div class="xl:col-span-2 budget-empty">
            <p class="text-lg font-semibold text-white">No hay sobres personalizados</p>
            <p class="mt-2 text-sm text-gray-400">Aún no has añadido categorías al presupuesto actual.</p>
        </div>
    @endforelse
</div>