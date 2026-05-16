<x-app-layout>
    <div class="budget-wrapper">
        <div class="budget-content">

            <div class="mb-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Editar Presupuesto</h2>
                    <p class="mt-1 text-sm text-gray-400">Modifica tu presupuesto mensual</p>
                </div>
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