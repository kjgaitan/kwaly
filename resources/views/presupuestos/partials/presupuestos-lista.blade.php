@php
    use App\Helpers\PresupuestoHelper;

    $meses = PresupuestoHelper::meses();
@endphp

<div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-5">
    <h3 class="mb-4 text-xl font-semibold text-white">Presupuestos creados</h3>

    <div class="grid gap-4">
        @foreach($presupuestos as $presupuesto)
            <div class="budget-panel-soft p-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h4 class="text-lg font-semibold text-white">
                            {{ $meses[$presupuesto->mes] ?? 'Mes desconocido' }} {{ $presupuesto->anio }}
                        </h4>

                        <p class="mt-1 text-sm text-gray-400">
                            Ingreso real:
                            <span class="font-semibold text-[#72f59a]">
                                {{ number_format($presupuesto->ingreso_real, 2, ',', '.') }}€
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