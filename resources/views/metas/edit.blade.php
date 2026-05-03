<x-app-layout>
    <div class="min-h-screen bg-[#050807] px-4 py-6 text-white md:px-6 lg:px-8">
        <div class="w-full rounded-[24px] border border-[#1c2a24] bg-[#0d1411] shadow-[0_0_0_1px_rgba(114,245,154,0.03)]">
            <div class="px-5 py-6 md:px-7 lg:px-8">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">
                            Editar Meta Financiera
                        </h1>
                        <p class="mt-1 text-sm text-gray-400">
                            Actualiza la información de tu meta.
                        </p>
                    </div>

                    <a href="{{ route('metas.index') }}"
                       class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-medium text-gray-300 transition hover:border-white/15 hover:bg-white/10 hover:text-white">
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </a>
                </div>


                <form action="{{ route('metas.update', $meta->id_meta) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @include('metas.partials.form', [
                        'modo' => 'editar'
                    ])

                    <div class="flex flex-col gap-3 border-t border-white/5 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <button type="submit"
                                    formaction="{{ route('metas.destroy', $meta->id_meta) }}"
                                    formmethod="POST"
                                    onclick="event.preventDefault(); if(confirm('¿Seguro que deseas eliminar esta meta?')) { document.getElementById('form-eliminar-meta').submit(); }"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-3 text-sm font-semibold text-red-300 transition hover:bg-red-500/20">
                                <i class="bi bi-trash"></i>
                                Eliminar
                            </button>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('metas.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#72f59a] px-5 py-3 text-sm font-semibold text-[#0b120f] transition hover:brightness-105">
                                <i class="bi bi-check-lg"></i>
                                Actualizar meta
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form-eliminar-meta" action="{{ route('metas.destroy', $meta->id_meta) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>