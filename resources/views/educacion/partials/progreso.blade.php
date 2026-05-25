<div class="rounded-[20px] border border-[#26352d] bg-[linear-gradient(180deg,#0e1411_0%,#0c110f_100%)] p-4 shadow-[0_0_16px_rgba(114,245,154,0.04)]">
    <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <p class="text-sm font-medium text-gray-200">Progreso de aprendizaje</p>
            <p class="mt-1 text-xs leading-5 text-gray-500">
                Se calcula con las lecciones completadas sobre el total de lecciones creadas en todos los módulos.
            </p>
        </div>
        <span class="text-sm font-semibold text-green-400">{{ $porcentajeProgreso }}%</span>
    </div>

    <div class="h-3 w-full overflow-hidden rounded-full bg-white/5">
        <div
            class="h-full rounded-full bg-[linear-gradient(90deg,#67e96f_0%,#4cf7c2_100%)] transition-all duration-500"
            style="width: {{ $porcentajeProgreso }}%;">
        </div>
    </div>

    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-gray-400">
        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">
            {{ $leccionesCompletadas }} completadas
        </span>
        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">
            {{ $totalLecciones }} lecciones disponibles
        </span>
    </div>
</div>
