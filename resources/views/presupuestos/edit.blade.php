<x-app-layout>
    <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
        <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Editar Presupuesto</h2>
                    <p class="mt-1 text-sm text-gray-400">Modifica tu presupuesto mensual</p>
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

            <form method="POST" action="{{ route('presupuestos.update', $presupuesto->id_presupuesto) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-gray-300">Año</label>
                        <input
                            type="number"
                            name="anio"
                            value="{{ old('anio', $presupuesto->anio) }}"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                            placeholder="2026"
                        >
                    </div>

                  <div>
                    <label class="mb-2 block text-sm text-gray-300">Mes</label>
                    <select
                        name="mes"
                        class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                    >
                        <option value="">Selecciona un mes</option>
                        <option value="1" {{ old('mes', $presupuesto->mes) == 1 ? 'selected' : '' }}>Enero</option>
                        <option value="2" {{ old('mes', $presupuesto->mes) == 2 ? 'selected' : '' }}>Febrero</option>
                        <option value="3" {{ old('mes', $presupuesto->mes) == 3 ? 'selected' : '' }}>Marzo</option>
                        <option value="4" {{ old('mes', $presupuesto->mes) == 4 ? 'selected' : '' }}>Abril</option>
                        <option value="5" {{ old('mes', $presupuesto->mes) == 5 ? 'selected' : '' }}>Mayo</option>
                        <option value="6" {{ old('mes', $presupuesto->mes) == 6 ? 'selected' : '' }}>Junio</option>
                        <option value="7" {{ old('mes', $presupuesto->mes) == 7 ? 'selected' : '' }}>Julio</option>
                        <option value="8" {{ old('mes', $presupuesto->mes) == 8 ? 'selected' : '' }}>Agosto</option>
                        <option value="9" {{ old('mes', $presupuesto->mes) == 9 ? 'selected' : '' }}>Septiembre</option>
                        <option value="10" {{ old('mes', $presupuesto->mes) == 10 ? 'selected' : '' }}>Octubre</option>
                        <option value="11" {{ old('mes', $presupuesto->mes) == 11 ? 'selected' : '' }}>Noviembre</option>
                        <option value="12" {{ old('mes', $presupuesto->mes) == 12 ? 'selected' : '' }}>Diciembre</option>
                    </select>
                </div>

                    <div>
                        <label class="mb-2 block text-sm text-gray-300">Ingreso estimado</label>
                        <input
                            type="number"
                            step="0.01"
                            name="ingreso_estimado"
                            value="{{ old('ingreso_estimado', $presupuesto->ingreso_estimado) }}"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                            placeholder="3500.00"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm text-gray-300">Porcentaje necesidades</label>
                        <input
                            type="number"
                            step="0.01"
                            name="porcentaje_necesidades"
                            value="{{ old('porcentaje_necesidades', $presupuesto->porcentaje_necesidades) }}"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm text-gray-300">Porcentaje deseos</label>
                        <input
                            type="number"
                            step="0.01"
                            name="porcentaje_deseos"
                            value="{{ old('porcentaje_deseos', $presupuesto->porcentaje_deseos) }}"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm text-gray-300">Porcentaje ahorro</label>
                        <input
                            type="number"
                            step="0.01"
                            name="porcentaje_ahorro"
                            value="{{ old('porcentaje_ahorro', $presupuesto->porcentaje_ahorro) }}"
                            class="w-full rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]"
                        >
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('presupuestos.index') }}"
                       class="rounded-xl border border-[#26352d] bg-[#111613] px-5 py-3 text-sm text-white transition hover:bg-[#1a211d]">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-black transition hover:bg-[#5ee38a]">
                        Actualizar
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>