@php
use App\Helpers\PresupuestoHelper;

$meses = PresupuestoHelper::meses();
$selectedPresupuestoId = session('presupuesto_activo_id') ?? ($presupuestoActual->id_presupuesto ?? null);
@endphp

<div class="mt-6 rounded-2xl border border-[#26352d] bg-[#171c19] p-5">
    <h3 class="mb-4 text-xl font-semibold text-white">
        Presupuestos creados
    </h3>

    <!-- Selector de Mes y Año -->
    <div class="mb-6 grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm text-gray-300">Mes</label>
            <select id="presupuestoMesSelector"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">
                <option value="">Seleccionar mes...</option>
                @foreach($meses as $numero => $nombre)
                <option value="{{ $numero }}" @selected(optional($presupuestoActual)->mes == $numero)>{{ $nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Año</label>
            <select id="presupuestoAnioSelector"
                class="w-full rounded-lg border border-[#2f3e36] bg-[#171c19] text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-lime-400">
                <option value="">Seleccionar año...</option>
                @php
                $anosDisponibles = $presupuestos->pluck('anio')->unique()->sort();
                @endphp
                @foreach($anosDisponibles as $anio)
                <option value="{{ $anio }}" @selected(optional($presupuestoActual)->anio == $anio)>{{ $anio }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-4">
        @foreach($presupuestos as $presupuesto)

        <div class="budget-panel-soft p-4">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div>
                    <h4 class="text-lg font-semibold text-white">
                        {{ $meses[$presupuesto->mes] ?? 'Mes desconocido' }}
                        {{ $presupuesto->anio }}
                    </h4>

                    <p class="mt-1 text-sm text-gray-400">
                        Ingreso:
                        <span class="font-semibold text-[#72f59a]">
                            {{ number_format($presupuesto->ingreso_estimado, 2, ',', '.') }}€
                        </span>
                    </p>

                    <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-400">
                        <span>
                            Necesidades:
                            {{ $presupuesto->porcentaje_necesidades }}%
                        </span>

                        <span>
                            Deseos:
                            {{ $presupuesto->porcentaje_deseos }}%
                        </span>

                        <span>
                            Ahorro:
                            {{ $presupuesto->porcentaje_ahorro }}%
                        </span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <form action="{{ route('presupuestos.select') }}" method="POST" class="inline-flex">
                        @csrf
                        <input type="hidden" name="id_presupuesto" value="{{ $presupuesto->id_presupuesto }}">
                        <button type="submit"
                            class="rounded-lg border border-[#26352d] px-4 py-2 text-sm text-white hover:bg-[#1a211d]">
                            Ver
                        </button>
                    </form>

                    <a href="{{ route('presupuestos.edit', $presupuesto->id_presupuesto) }}"
                        class="rounded-lg border border-[#26352d] px-4 py-2 text-sm text-white hover:bg-[#1a211d]">
                        Editar
                    </a>

                    <button type="button" onclick="openDeleteModal('deleteModal-{{ $presupuesto->id_presupuesto }}')"
                        class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm text-red-400 hover:bg-red-500/20">
                        Eliminar
                    </button>

                    <x-delete-modal id="deleteModal-{{ $presupuesto->id_presupuesto }}" title="¿Eliminar presupuesto?"
                        message="Este presupuesto se eliminará permanentemente. Esta operación es irreversible."
                        :action="route('presupuestos.destroy', $presupuesto->id_presupuesto)" method="DELETE" />

                </div>

            </div>
        </div>

        @endforeach
    </div>
</div>

<form id="presupuestoSeleccionForm" action="{{ route('presupuestos.select') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="id_presupuesto" id="presupuestoSeleccionId" value="{{ $selectedPresupuestoId }}">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mesSelector = document.getElementById('presupuestoMesSelector');
    const anioSelector = document.getElementById('presupuestoAnioSelector');
    const seleccionForm = document.getElementById('presupuestoSeleccionForm');
    const presupuestoSeleccionId = document.getElementById('presupuestoSeleccionId');

    const presupuestos = @json($presupuestos - > map - > only(['id_presupuesto', 'mes', 'anio']));

    function selectBudget(presupuestoId) {
        presupuestoSeleccionId.value = presupuestoId;
        seleccionForm.submit();
    }

    function handlePresupuestoSelection() {
        const mes = mesSelector.value;
        const anio = anioSelector.value;

        if (!mes || !anio) {
            return;
        }

        const presupuestoSeleccionado = presupuestos.find(p =>
            parseInt(p.mes, 10) === parseInt(mes, 10) &&
            parseInt(p.anio, 10) === parseInt(anio, 10)
        );

        if (presupuestoSeleccionado) {
            selectBudget(presupuestoSeleccionado.id_presupuesto);
        } else {
            alert('No existe presupuesto para el mes y año seleccionados.');
            mesSelector.value = '';
            anioSelector.value = '';
        }
    }

    mesSelector.addEventListener('change', handlePresupuestoSelection);
    anioSelector.addEventListener('change', handlePresupuestoSelection);

    window.selectBudget = selectBudget;
});
</script>