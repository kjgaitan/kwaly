@if(isset($metasPausadas) && $metasPausadas->count() > 0)
    <div class="mb-8">
        <h2 class="mb-4 text-base font-semibold text-white">
            Metas en pausa
        </h2>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            @foreach ($metasPausadas as $meta)
                <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-4 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl border border-yellow-400/20 bg-yellow-500/10 text-[#facc15]">
                                <i class="bi bi-pause text-2xl"></i>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $meta['titulo'] }}
                                </h3>
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $meta['fecha_limite'] ?? 'Sin fecha límite' }}
                                </p>
                            </div>
                        </div>

                        <span class="inline-flex items-center rounded-full border border-yellow-400/20 bg-yellow-500/10 px-3 py-1 text-xs font-medium text-[#facc15]">
                            Pausada
                        </span>
                    </div>

                    <div class="mt-4 text-sm text-gray-400">
                        <p><span class="font-semibold text-white">Objetivo:</span> {{ number_format($meta['monto_objetivo'] ?? 0, 0, ',', '.') }}€</p>
                        <p><span class="font-semibold text-white">Actual:</span> {{ number_format($meta['monto_actual'] ?? 0, 0, ',', '.') }}€</p>
                    </div>

                    <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('metas.edit', $meta['id_meta']) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-gray-300 transition hover:border-white/20 hover:bg-white/10 hover:text-white">
                            <i class="bi bi-pencil"></i>
                            Editar
                        </a>

                        <button type="button"
                                onclick="openDeleteModal('deleteModalMeta{{ $meta['id_meta'] }}')"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-2 text-sm font-medium text-red-300 transition hover:bg-red-500/20">
                            <i class="bi bi-trash"></i>
                            Eliminar
                        </button>
                    </div>

                    <x-delete-modal id="deleteModalMeta{{ $meta['id_meta'] }}"
                                   title="¿Eliminar esta meta?"
                                   message="Una vez eliminada, no podrás recuperar esta meta ni su historial." />

                    <form id="delete-form-deleteModalMeta{{ $meta['id_meta'] }}"
                          action="{{ route('metas.destroy', $meta['id_meta']) }}"
                          method="POST"
                          class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif
