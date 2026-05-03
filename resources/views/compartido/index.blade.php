<x-app-layout>
    <div class="compartido-page">
        <div class="compartido-container">

            <div class="compartido-header">
                <div>
                    <h1 class="compartido-title">Cuenta Compartida</h1>
                    <p class="compartido-subtitle">Gestión financiera colaborativa</p>
                </div>

                @if($grupo)
                    <a href="#form-miembro" class="compartido-btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Invitar miembro
                    </a>
                @endif
            </div>

            @if(!$grupo)
                @include('compartido.partials.empty-state')
            @else
                @include('compartido.partials.resumen')

                <div class="mb-8">
                    @include('compartido.partials.miembros')
                </div>

                <div class="mb-8">
                    @include('compartido.partials.gastos')
                </div>

                <div class="compartido-grid-forms">
                    @include('compartido.partials.form-miembro')
                    @include('compartido.partials.form-gasto')
                </div>

                @include('compartido.partials.leyenda')
            @endif

        </div>
    </div>
</x-app-layout>