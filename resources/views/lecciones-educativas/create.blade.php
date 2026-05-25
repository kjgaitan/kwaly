<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="mx-auto max-w-4xl rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                    Crear lección para el módulo: {{ $modulo->titulo }}
                </h1>
                <p class="mt-1 text-sm text-gray-400">
                    Elige una plantilla relacionada con este módulo o crea una lección personalizada.
                </p>
            </div>

            <form action="{{ route('modulos-educativos.lecciones.store', ['modulo' => $modulo->id_modulo]) }}" method="POST" novalidate>
                @csrf
                @include('lecciones-educativas.partials.form', ['textoBoton' => 'Guardar lección'])
            </form>
        </div>
    </div>
</x-app-layout>
