@php $detalle = null; @endphp

<x-app-layout>
    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Crear Sobre</h2>
                    <p class="mt-1 text-sm text-gray-400">
                        Presupuesto de {{ $presupuesto->mes }}/{{ $presupuesto->anio }}
                    </p>
                </div>

                <a href="{{ route('presupuestos.index') }}"
                   class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2 text-sm text-white transition hover:bg-[#1a211d]">
                    Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('presupuestos.sobres.store', $presupuesto->id_presupuesto) }}" class="space-y-6">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="id_categoria" class="mb-2 block text-sm font-medium text-white">Categoría</label>
                        <select name="id_categoria" id="id_categoria"
                                class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="limite_monto" class="mb-2 block text-sm font-medium text-white">Límite de monto</label>
                        <input type="number" step="0.01" name="limite_monto" id="limite_monto"
                               value="{{ old('limite_monto') }}"
                               class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white">
                    </div>

                    <div>
                        <label for="monto_gastado" class="mb-2 block text-sm font-medium text-white">Monto gastado</label>
                        <input type="number" step="0.01" name="monto_gastado" id="monto_gastado"
                               value="{{ old('monto_gastado', 0) }}"
                               class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('presupuestos.index') }}"
                       class="rounded-xl border border-[#26352d] bg-[#111613] px-5 py-3 text-sm text-white transition hover:bg-[#1a211d]">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                        Guardar sobre
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>