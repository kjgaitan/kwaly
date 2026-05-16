<x-app-layout>
    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <div class="mb-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Editar Sobre</h2>
                    <p class="mt-1 text-sm text-gray-400">Actualiza los datos del sobre</p>
                </div>
            </div>


            <form method="POST" action="{{ route('sobres.update', $detalle->id_detalle) }}" class="space-y-6" novalidate>
                @csrf
                @method('PUT')

                @include('sobres.partials.form')

                <div class="flex justify-end gap-3">
                    <a href="{{ route('presupuestos.index') }}"
                       class="rounded-xl border border-[#26352d] bg-[#111613] px-5 py-3 text-sm text-white transition hover:bg-[#1a211d]">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                        Actualizar sobre
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>