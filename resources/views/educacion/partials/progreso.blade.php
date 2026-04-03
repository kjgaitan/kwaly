<div class="rounded-[20px] border border-[#26352d] bg-[linear-gradient(180deg,#0e1411_0%,#0c110f_100%)] p-4 shadow-[0_0_16px_rgba(114,245,154,0.04)]">
    <div class="mb-3 flex items-center justify-between gap-3">
        <p class="text-sm font-medium text-gray-300">Tu Progreso de Aprendizaje</p>
        <span class="text-sm font-semibold text-green-400">{{ $porcentajeProgreso }}%</span>
    </div>

    <div class="h-3 w-full overflow-hidden rounded-full bg-white/5">
        <div
            class="h-full rounded-full bg-[linear-gradient(90deg,#67e96f_0%,#4cf7c2_100%)] transition-all duration-500"
            style="width: {{ $porcentajeProgreso }}%;">
        </div>
    </div>
</div>