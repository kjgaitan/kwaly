<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
    <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-4 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
        <div class="mb-3 flex items-start justify-between">
            <div>
                <p class="text-[11px] text-gray-400">Metas Completadas</p>
                <p class="mt-3 text-3xl font-bold text-[#72f59a]">
                    {{ $resumen['metas_completadas'] ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/15 text-[#72f59a]">
                <i class="bi bi-trophy text-sm"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-4 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
        <div class="mb-3 flex items-start justify-between">
            <div>
                <p class="text-[11px] text-gray-400">Metas Activas</p>
                <p class="mt-3 text-3xl font-bold text-[#60a5fa]">
                    {{ $resumen['metas_activas'] ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/15 text-[#60a5fa]">
                <i class="bi bi-stars text-sm"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-4 shadow-[0_0_20px_rgba(33,120,73,0.35)]">
        <div class="mb-3 flex items-start justify-between">
            <div>
                <p class="text-[11px] text-gray-400">Logros Desbloqueados</p>
                <p class="mt-3 text-3xl font-bold text-[#facc15]">
                    {{ $resumen['logros_desbloqueados'] ?? 0 }}/{{ $resumen['total_logros'] ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-500/15 text-[#facc15]">
                <i class="bi bi-award text-sm"></i>
            </div>
        </div>
    </div>
</div>