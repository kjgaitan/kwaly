<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="mx-auto max-w-4xl rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">
            <div class="mb-6">
                <p class="text-sm text-green-400">Módulo: {{ $modulo->titulo }}</p>
                <h1 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                    Editar lección
                </h1>
                <p class="mt-1 text-sm text-gray-400">
                    Modifica la información de la lección asociada a este módulo.
                </p>
            </div>

            <form action="{{ route('modulos-educativos.lecciones.update', ['modulo' => $modulo->id_modulo, 'leccion' => $leccion->id_leccion]) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('lecciones-educativas.partials.form', ['textoBoton' => 'Actualizar lección'])
            </form>
        </div>
    </div>
</x-app-layout>
