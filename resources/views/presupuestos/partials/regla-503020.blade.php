@php
    use App\Helpers\PresupuestoHelper;
@endphp

<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">

    <div class="budget-panel">
        <div class="mb-5 flex items-start justify-between">
            <div class="budget-card-icon">🏠</div>
        </div>

        <h3 class="text-xl font-semibold text-white">Necesidades</h3>
        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcNecesidades, 0) }}% del ingreso</p>

        <div class="mt-6">
            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                <span>Gastado</span>
                <span>{{ number_format($gastadoNecesidades, 2, ',', '.') }}€ / {{ number_format($montoNecesidades, 2, ',', '.') }}€</span>
            </div>

            <div class="budget-progress-track">
                <div class="h-full rounded-full bg-[#72f59a]" style="width: {{ $porcentajeUsoNecesidades }}%"></div>
            </div>
        </div>

        <div class="budget-info-box">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-400">Disponible</span>
                <span class="text-xl font-semibold {{ PresupuestoHelper::colorDisponible($dispNecesidades) }}">
                    {{ number_format($dispNecesidades, 2, ',', '.') }}€
                </span>
            </div>
        </div>
    </div>

    <div class="budget-panel">
        <div class="mb-5 flex items-start justify-between">
            <div class="budget-card-icon">🛍</div>
        </div>

        <h3 class="text-xl font-semibold text-white">Deseos</h3>
        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcDeseos, 0) }}% del ingreso</p>

        <div class="mt-6">
            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                <span>Gastado</span>
                <span>{{ number_format($gastadoDeseos, 2, ',', '.') }}€ / {{ number_format($montoDeseos, 2, ',', '.') }}€</span>
            </div>

            <div class="budget-progress-track">
                <div class="h-full rounded-full bg-[#72f59a]" style="width: {{ $porcentajeUsoDeseos }}%"></div>
            </div>
        </div>

        <div class="budget-info-box">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-400">Disponible</span>
                <span class="text-xl font-semibold {{ PresupuestoHelper::colorDisponible($dispDeseos) }}">
                    {{ number_format($dispDeseos, 2, ',', '.') }}€
                </span>
            </div>
        </div>
    </div>

    <div class="budget-panel">
        <div class="mb-5 flex items-start justify-between">
            <div class="budget-card-icon">☆</div>

            @if($porcentajeUsoAhorro >= 100)
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-500/10 text-yellow-400">
                    ⚠
                </div>
            @endif
        </div>

        <h3 class="text-xl font-semibold text-white">Ahorro</h3>
        <p class="mt-1 text-sm text-gray-400">{{ number_format($porcAhorro, 0) }}% del ingreso</p>

        <div class="mt-6">
            <div class="mb-2 flex items-center justify-between text-sm text-gray-400">
                <span>Gastado</span>
                <span>{{ number_format($gastadoAhorro, 2, ',', '.') }}€ / {{ number_format($montoAhorro, 2, ',', '.') }}€</span>
            </div>

            <div class="budget-progress-track">
                <div class="h-full rounded-full {{ PresupuestoHelper::colorBarraAhorro($porcentajeUsoAhorro) }}"
                     style="width: {{ $porcentajeUsoAhorro }}%"></div>
            </div>
        </div>

        <div class="budget-info-box">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-400">Disponible</span>
                <span class="text-xl font-semibold {{ PresupuestoHelper::colorDisponible($dispAhorro) }}">
                    {{ number_format($dispAhorro, 2, ',', '.') }}€
                </span>
            </div>
        </div>
    </div>
</div>