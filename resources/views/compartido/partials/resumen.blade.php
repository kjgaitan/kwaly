<div class="compartido-grid-resumen">
    <div class="compartido-card compartido-card-padding">
        <div class="compartido-stat-top">
            <div>
                <p class="compartido-stat-label">Total Aportado</p>
                <h3 class="compartido-stat-value compartido-stat-value-green">
                    {{ number_format($resumen['total_aportado'], 0, ',', '.') }}€
                </h3>
                <p class="compartido-stat-note">
                    Por {{ $resumen['numero_miembros'] }} miembro(s)
                </p>
            </div>

            <div class="compartido-stat-icon compartido-stat-icon-green">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>

    <div class="compartido-card compartido-card-padding">
        <div class="compartido-stat-top">
            <div>
                <p class="compartido-stat-label">Total Gastado</p>
                <h3 class="compartido-stat-value compartido-stat-value-red">
                    {{ number_format($resumen['total_gastado'], 0, ',', '.') }}€
                </h3>
                <p class="compartido-stat-note">
                    {{ $gastos->count() }} transacción(es)
                </p>
            </div>

            <div class="compartido-stat-icon compartido-stat-icon-red">
                <i class="bi bi-graph-down-arrow"></i>
            </div>
        </div>
    </div>

    <div class="compartido-card compartido-card-padding">
        <div class="compartido-stat-top">
            <div>
                <p class="compartido-stat-label">Balance Grupal</p>
                <h3 class="compartido-stat-value compartido-stat-value-green">
                    {{ number_format($resumen['balance_general'], 0, ',', '.') }}€
                </h3>
                <p class="compartido-stat-note">Disponible</p>
            </div>

            <div class="compartido-stat-icon compartido-stat-icon-green">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>
    </div>
</div>