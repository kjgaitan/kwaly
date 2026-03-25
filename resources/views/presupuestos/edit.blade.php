<x-app-layout>
    <div class="budget-wrapper">
        <div class="budget-content">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Editar Presupuesto</h2>
                    <p class="mt-1 text-sm text-gray-400">Modifica tu presupuesto mensual</p>
                </div>

                <a href="{{ route('presupuestos.index') }}" class="budget-btn-secondary">
                    Volver
                </a>
            </div>

            @include('presupuestos.partials.form', [
                'action' => route('presupuestos.update', $presupuesto->id_presupuesto),
                'method' => 'PUT',
                'submitText' => 'Actualizar',
                'presupuesto' => $presupuesto,
            ])

        </div>
    </div>
</x-app-layout>