<x-app-layout>
    <div class="budget-wrapper">
        <div class="budget-content">

            @include('presupuestos.partials.index-header')

            @include('presupuestos.partials.flash-messages')

            @if(!$presupuestoActual)
                @include('presupuestos.partials.empty-state')
            @else
                @include('presupuestos.partials.regla-503020')

                @include('presupuestos.partials.sobres')

                @include('presupuestos.partials.resumen')

                @include('presupuestos.partials.presupuestos-lista')
            @endif

        </div>
    </div>
</x-app-layout>