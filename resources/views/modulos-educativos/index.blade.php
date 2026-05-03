<td class="px-4 py-4 align-top">
    <div class="flex flex-wrap items-center justify-end gap-2">
        <a href="{{ route('modulos-educativos.lecciones.index', $modulo) }}"
           class="inline-flex items-center gap-2 rounded-lg border border-green-500/20 bg-green-500/10 px-3 py-2 text-sm text-green-400 transition hover:bg-green-500/20">
            <i class="bi bi-collection-play"></i>
            <span>Lecciones</span>
        </a>

        <a href="{{ route('modulos-educativos.edit', $modulo) }}"
           class="inline-flex items-center gap-2 rounded-lg border border-white/5 bg-white/[0.03] px-3 py-2 text-sm text-white transition hover:border-green-500/20 hover:bg-white/[0.05]">
            <i class="bi bi-pencil-square"></i>
            <span>Editar</span>
        </a>

        <button type="button"
                onclick="openDeleteModal('deleteModal-modulo-{{ $modulo->id_modulo_educativo }}')"
                class="inline-flex items-center gap-2 rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-2 text-sm text-red-400 transition hover:bg-red-500/20">
            <i class="bi bi-trash3"></i>
            <span>Eliminar</span>
        </button>

        <x-delete-modal
            id="deleteModal-modulo-{{ $modulo->id_modulo_educativo }}"
            title="¿Eliminar módulo educativo?"
            message="Este módulo y sus lecciones asociadas se eliminarán permanentemente. Esta operación es irreversible."
            :action="route('modulos-educativos.destroy', $modulo)"
            method="DELETE"
        />
    </div>
</td>