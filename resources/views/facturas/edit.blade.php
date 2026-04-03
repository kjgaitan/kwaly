<x-app-layout>
    <div class="mx-auto max-w-4xl">
        <div class="rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="border-b border-[#26352d] px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Editar Factura</h1>
                <p class="mt-1 text-sm text-gray-400">Actualiza los datos de la factura seleccionada.</p>
            </div>

            <div class="px-6 py-6">
                @if($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        Revisa los campos del formulario.
                    </div>
                @endif

                <form action="{{ route('facturas.update', $factura->id_factura) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('facturas.partials.form', [
                        'factura' => $factura,
                        'boton' => 'Actualizar factura'
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>