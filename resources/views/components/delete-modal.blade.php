@props(['id' => 'deleteModal', 'title' => '¿Eliminar registro?', 'message' => 'Esta operación es irreversible. Perderá los datos para siempre.', 'action' => '', 'method' => 'DELETE'])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-[400px] rounded-2xl border border-red-500/20 bg-[#0d1310] p-6 shadow-2xl">
        <!-- Encabezado -->
        <div class="mb-4 flex items-start gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-500/20 bg-red-500/10">
                <i class="bi bi-exclamation-triangle text-2xl text-red-400"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
                <p class="mt-2 text-sm text-gray-300">{{ $message }}</p>
            </div>
        </div>

        <!-- Acciones -->
        <div class="mt-6 flex gap-3">
            <button
                type="button"
                onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                class="flex-1 rounded-lg border border-gray-500/20 bg-gray-500/10 px-4 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-500/20"
            >
                Cancelar
            </button>

            @if ($action && $method)
                <form action="{{ $action }}" method="POST" class="flex-1">
                    @csrf
                    @method($method)
                    <button
                        type="submit"
                        class="w-full rounded-lg border border-red-500/30 bg-red-500/20 px-4 py-2.5 text-sm font-semibold text-red-300 transition hover:bg-red-500/30"
                    >
                        Eliminar
                    </button>
                </form>
            @else
                <button
                    type="button"
                    onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                    class="flex-1 rounded-lg border border-red-500/30 bg-red-500/20 px-4 py-2.5 text-sm font-semibold text-red-300 transition hover:bg-red-500/30"
                >
                    Eliminar
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Script para abrir el modal -->
<script>
    function openDeleteModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).classList.add('flex');
    }

    function closeDeleteModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).classList.remove('flex');
    }

    // Cerrar al hacer clic fuera del modal
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('[id*="deleteModal"]');
        modals.forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    this.classList.remove('flex');
                }
            });
        });
    });
</script>
