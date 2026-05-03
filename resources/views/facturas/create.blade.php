<x-app-layout>
    <div class="mx-auto max-w-4xl">
        <div class="rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="border-b border-[#26352d] px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Nueva Factura</h1>
                <p class="mt-1 text-sm text-gray-400">Registra una nueva factura o pago programado.</p>
            </div>

            <div class="px-6 py-6">

                <form action="{{ route('facturas.store') }}" method="POST">
                    @csrf
                    @include('facturas.partials.form', [
                        'factura' => null,
                        'boton' => 'Guardar factura'
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>