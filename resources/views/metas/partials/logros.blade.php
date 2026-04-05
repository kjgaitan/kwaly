<div class="mb-6">
    <h2 class="mb-4 text-base font-semibold text-white">
        Logros y Medallas
    </h2>

    @if(isset($logros) && count($logros) > 0)
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($logros as $logro)
                <div class="relative rounded-2xl border border-[#1f4d35] bg-[#1b1b1d] p-5 text-center shadow-[0_0_20px_rgba(33,120,73,0.35)] {{ $logro['desbloqueado'] ? '' : 'opacity-80' }}">
                    @if($logro['desbloqueado'])
                        <div class="absolute right-3 top-3 flex h-5 w-5 items-center justify-center rounded-full bg-[#72f59a] text-[10px] text-[#171c19]">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    @endif

                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl border border-green-400/20 bg-green-500/10 text-[#72f59a]">
                        <i class="{{ $logro['icono'] }} text-xl"></i>
                    </div>

                    <h3 class="text-sm font-semibold text-white">
                        {{ $logro['titulo'] }}
                    </h3>

                    <p class="mt-3 text-xs leading-5 text-gray-400">
                        {{ $logro['descripcion'] }}
                    </p>

                    @if($logro['desbloqueado'])
                        <span class="mt-4 inline-flex items-center rounded-full border border-green-400/20 bg-green-500/10 px-3 py-1 text-[11px] font-medium text-[#72f59a]">
                            Desbloqueado
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>