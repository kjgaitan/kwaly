<x-app-layout>
    <div class="budget-wrapper">
        <div class="budget-content">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        Presupuesto de {{ $presupuesto->mes }}/{{ $presupuesto->anio }}
                    </h1>
                    <p class="mt-2 text-gray-400">
                        Detalles y seguimiento del presupuesto mensual
                    </p>
                </div>
                <a href="{{ route('presupuestos.index') }}"
                    class="rounded-lg border border-[#26352d] px-6 py-2 text-white hover:bg-[#1a211d] transition-colors">
                    ← Volver
                </a>
            </div>

            <!-- Información principal del presupuesto -->
            <div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-400">Ingreso estimado</p>
                        <p class="text-2xl font-semibold text-[#72f59a] mt-2">
                            {{ number_format($presupuesto->ingreso_estimado, 2, ',', '.') }}€
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Distribución (50/30/20)</p>
                        <div class="mt-2 flex gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-400">Necesidades</p>
                                <p class="text-xl font-semibold text-white">{{ $presupuesto->porcentaje_necesidades }}%
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-400">Deseos</p>
                                <p class="text-xl font-semibold text-white">{{ $presupuesto->porcentaje_deseos }}%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-400">Ahorro</p>
                                <p class="text-xl font-semibold text-white">{{ $presupuesto->porcentaje_ahorro }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sobres/Detalles del presupuesto -->
            <div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-5">
                <h3 class="mb-4 text-xl font-semibold text-white">
                    Sobres personalizados
                </h3>

                @if($presupuesto->detalles->isEmpty())
                <p class="text-gray-400">
                    No hay sobres creados para este presupuesto.
                </p>
                @else
                <div class="grid gap-4">
                    @foreach($presupuesto->detalles as $detalle)
                    <div class="budget-panel-soft p-4">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-white">
                                    {{ $detalle->categoria->nombre ?? 'Categoría desconocida' }}
                                </h4>
                                <p class="mt-1 text-sm text-gray-400">
                                    Tipo:
                                    <span class="font-semibold text-[#72f59a]">
                                        {{ ucfirst($detalle->tipo_presupuesto) }}
                                    </span>
                                </p>
                            </div>

                            <div class="flex flex-col gap-2 md:text-right">
                                <div>
                                    <p class="text-sm text-gray-400">Límite</p>
                                    <p class="text-lg font-semibold text-white">
                                        {{ number_format($detalle->limite_monto, 2, ',', '.') }}€
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Gastado</p>
                                    <p
                                        class="text-lg font-semibold {{ $detalle->monto_gastado > $detalle->limite_monto ? 'text-red-400' : 'text-[#72f59a]' }}">
                                        {{ number_format($detalle->monto_gastado, 2, ',', '.') }}€
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Disponible</p>
                                    <p
                                        class="text-lg font-semibold {{ $detalle->limite_monto - $detalle->monto_gastado < 0 ? 'text-red-400' : 'text-white' }}">
                                        {{ number_format($detalle->limite_monto - $detalle->monto_gastado, 2, ',', '.') }}€
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Botones de acción -->
            <div class="mt-6 flex gap-3">
                <a href="{{ route('presupuestos.edit', $presupuesto->id_presupuesto) }}"
                    class="rounded-lg border border-[#26352d] px-6 py-2 text-white hover:bg-[#1a211d] transition-colors">
                    Editar
                </a>

                <button type="button" onclick="openDeleteModal('presupuestoDeleteModal')"
                    class="rounded-lg border border-red-500/30 bg-red-500/10 px-6 py-2 text-red-400 hover:bg-red-500/20 transition-colors">
                    Eliminar
                </button>

                <x-delete-modal id="presupuestoDeleteModal" title="¿Eliminar presupuesto?"
                    message="Este presupuesto se eliminará permanentemente. Esta operación es irreversible."
                    :action="route('presupuestos.destroy', $presupuesto->id_presupuesto)" method="DELETE" />
            </div>

        </div>
    </div>
</x-app-layout>