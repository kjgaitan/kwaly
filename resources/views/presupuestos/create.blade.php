<x-app-layout>
    <div class="budget-wrapper">
        <div class="budget-content">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Crear Presupuesto</h2>
                    <p class="mt-1 text-sm text-gray-400">Configura tu presupuesto mensual</p>
                </div>
            </div>

            @include('presupuestos.partials.form', [
                'action' => route('presupuestos.store'),
                'method' => 'POST',
                'submitText' => 'Guardar presupuesto',
            ])

        </div>
    </div>
</x-app-layout>