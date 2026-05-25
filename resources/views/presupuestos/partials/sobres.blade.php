<div class="mb-4 flex items-center justify-between">
    <div>
        <h3 class="text-xl font-semibold text-white">Sobres Personalizados</h3>
        <p class="text-sm text-gray-400">
            Gestiona los límites de gasto por categoría
        </p>
    </div>

    @if($presupuestoActual)
    <a href="{{ route('presupuestos.sobres.create', $presupuestoActual->id_presupuesto) }}"
        class="budget-btn-primary inline-flex items-center gap-2">

        <i class="bi bi-plus-lg"></i>
        Crear Sobre

    </a>
    @endif
</div>

<div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
    @forelse($detalles as $detalle)
    @php
    $limite = (float) $detalle->limite_monto;
    $gastado = (float) $detalle->monto_gastado;
    $uso = $limite > 0 ? min(($gastado / $limite) * 100, 100) : 0;
    $restante = max($limite - $gastado, 0);

    $categoriaNombre = $detalle->categoria->nombre ?? 'Categoría';
    $colorBarra = \App\Helpers\PresupuestoHelper::colorUsoSobre($uso);
    @endphp

    <div class="budget-panel">
        <div class="mb-4 flex items-start justify-between">
            <div class="flex items-center gap-3">
                <span class="text-lg text-[#72f59a]">●</span>

                <div>
                    <h4 class="font-semibold text-white">
                        {{ $categoriaNombre }}
                    </h4>

                    <p class="text-xs text-gray-500">
                        Límite mensual asignado
                    </p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-sm font-semibold text-white">
                    {{ number_format($gastado, 2, ',', '.') }}€
                </p>

                <p class="text-xs text-gray-500">
                    de {{ number_format($limite, 2, ',', '.') }}€
                </p>
            </div>
        </div>

        <div class="mb-2 flex items-center justify-between text-xs text-gray-400">
            <span>{{ number_format($uso, 0) }}% utilizado</span>

            <span>
                Restan {{ number_format($restante, 2, ',', '.') }}€
            </span>
        </div>

        <div class="budget-progress-track">
            <div class="h-full rounded-full {{ $colorBarra }}" style="width: {{ $uso }}%">
            </div>
        </div>

        @if($uso >= 80 && $uso < 100) <div class="budget-alert-warning">
            ⚠ Has gastado el {{ number_format($uso, 0) }}% del presupuesto de {{ strtolower($categoriaNombre) }} este
            mes.
    </div>
    @endif

    @if($uso >= 100)
    <div class="budget-alert-warning">
        ⚠ Has alcanzado o superado el límite del presupuesto de {{ strtolower($categoriaNombre) }}.
    </div>
    @endif
    <div class="mt-3 flex justify-end gap-2">
        <a href="{{ route('sobres.edit', $detalle->id_detalle) }}"
            class="rounded-xl border border-[#26352d] bg-[#111613] px-3 py-2 text-xs text-white transition hover:bg-[#1a211d]">
            Editar
        </a>

        <button type="button" onclick="openDeleteModal('deleteModal-sobre-{{ $detalle->id_detalle }}')"
            class="rounded-xl bg-[#ff6b6b] px-3 py-2 text-xs font-semibold text-white transition hover:opacity-90">
            Eliminar
        </button>

        <x-delete-modal id="deleteModal-sobre-{{ $detalle->id_detalle }}" title="¿Eliminar sobre?"
            message="Este sobre se eliminará permanentemente. Esta operación es irreversible."
            :action="route('sobres.destroy', $detalle->id_detalle)" method="DELETE" />
    </div>
</div>
@empty
<div class="xl:col-span-2 budget-empty">
    <p class="text-lg font-semibold text-white">
        No hay sobres personalizados
    </p>

    <p class="mt-2 text-sm text-gray-400">
        No has añadido categorías al presupuesto actual.
    </p>
</div>
@endforelse
</div>