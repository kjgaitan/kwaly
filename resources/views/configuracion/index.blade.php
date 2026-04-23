<x-app-layout>
    <div class="config-wrapper">
        <div class="config-container">

            <div class="config-header">
                <h1>Configuración</h1>
                <p>Personaliza tu experiencia en KWALY</p>
            </div>

            @if(session('success'))
                <div class="config-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @include('configuracion.partials.perfil-card')
            @include('configuracion.partials.moneda-card')
            @include('configuracion.partials.notificaciones-card')
            @include('configuracion.partials.seguridad-card')
            @include('configuracion.partials.peligro-card')

        </div>
    </div>
</x-app-layout>