<h2 class="compartido-section-title">Gastos Compartidos Recientes</h2>

<div class="compartido-gastos-list">
    @forelse($gastos as $gasto)
        <div class="compartido-gasto-item">
            <div class="compartido-gasto-content">
                <div class="compartido-gasto-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h3>{{ $gasto->titulo }}</h3>

                        <span class="compartido-badge compartido-badge-admin">
                            Compartido
                        </span>
                    </div>

                    <p class="compartido-gasto-meta">
                        Pagado por {{ $gasto->pagador?->nombre ?? 'Usuario' }}
                        <span class="mx-2 text-gray-600">→</span>
                        {{ optional($gasto->fecha_gasto)->format('d/m/Y') }}
                    </p>
                </div>

                <div class="compartido-gasto-right">
                    <p class="compartido-gasto-total">
                        {{ number_format($gasto->monto_total, 0, ',', '.') }}€
                    </p>
                    <p class="compartido-gasto-extra">
                        {{ $resumen['numero_miembros'] > 0 ? number_format($gasto->monto_total / $resumen['numero_miembros'], 2, ',', '.') : '0,00' }}€
                        por persona
                    </p>
                </div>
            </div>
        </div>
    @empty
        <div class="compartido-card compartido-card-padding text-gray-400">
            No hay gastos compartidos registrados todavía.
        </div>
    @endforelse
</div>