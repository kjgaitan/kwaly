@php $detalle = null; @endphp
<x-app-layout>
    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <div class="mb-6 flex flex-col gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Crear Sobre</h2>
                    <p class="mt-1 text-sm text-gray-400">
                        Presupuesto de {{ $presupuesto->mes }}/{{ $presupuesto->anio }}
                    </p>
                </div>

                <div id="budget-summary-card" class="rounded-2xl border border-[#2d6f4f] bg-[#152c23] p-4 text-white">
                    <p class="text-xs uppercase tracking-wide text-[#94f3bb]">Presupuesto seleccionado</p>
                    <p id="budget-summary-month-year" class="mt-1 text-lg font-semibold">
                        {{ $presupuesto->mes }}/{{ $presupuesto->anio }}</p>
                    <p id="budget-summary-income" class="mt-1 text-sm text-gray-300">Ingreso:
                        {{ number_format($presupuesto->ingreso_estimado, 2, ',', '.') }} €</p>
                </div>
            </div>


            <form method="POST" action="{{ route('presupuestos.sobres.store', $presupuesto->id_presupuesto) }}"
                class="space-y-6" novalidate>
                @csrf

                @include('sobres.partials.form')

                <div class="flex justify-end gap-3">
                    <a href="{{ route('presupuestos.index') }}"
                        class="rounded-xl border border-[#26352d] bg-[#111613] px-5 py-3 text-sm text-white transition hover:bg-[#1a211d]">
                        Cancelar
                    </a>

                    <button type="submit" {{ $categorias->isEmpty() ? 'disabled' : '' }}
                        class="rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-black transition {{ $categorias->isEmpty() ? 'cursor-not-allowed opacity-50' : 'hover:bg-[#5ee38a]' }}">
                        Guardar sobre
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>