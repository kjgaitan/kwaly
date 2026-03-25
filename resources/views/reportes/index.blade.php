<x-app-layout>
    <div class="report-wrapper">
        <div class="report-content">

            <div class="report-header">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-white">Reportes</h2>
                    <p class="mt-1 text-sm text-gray-400">Analiza tus tendencias financieras</p>
                </div>

                <form method="GET" action="{{ route('reportes.index') }}" class="report-filter-form">
                    <div class="report-filter-group">
                        <label for="anio" class="report-filter-label">Año</label>
                        <select name="anio" id="anio" class="report-input">
                            @foreach ($aniosDisponibles as $itemAnio)
                                <option value="{{ $itemAnio }}" {{ (int) $anio === (int) $itemAnio ? 'selected' : '' }}>
                                    {{ $itemAnio }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="report-filter-group">
                        <label for="mes" class="report-filter-label">Mes</label>
                        <select name="mes" id="mes" class="report-input">
                            @foreach ($mesesSelect as $numeroMes => $nombreMes)
                                <option value="{{ $numeroMes }}" {{ (int) $mes === (int) $numeroMes ? 'selected' : '' }}>
                                    {{ $nombreMes }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="report-btn">
                            Aplicar
                        </button>
                    </div>
                </form>
            </div>

            <div class="report-grid-top">
                <div class="report-panel">
                    <div class="report-panel-title-row">
                        <div class="report-panel-title">
                            <div class="report-title-dot"></div>
                            <h3 class="report-panel-label">Ingresos vs Gastos</h3>
                        </div>
                        <span class="report-panel-meta">{{ $anio }}</span>
                    </div>

                    <div class="report-chart-box">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <div class="report-panel">
                    <div class="report-panel-title-row">
                        <div class="report-panel-title">
                            <div class="report-title-dot"></div>
                            <h3 class="report-panel-label">Gastos por Categoría</h3>
                        </div>
                        <span class="report-panel-meta">{{ $mesesSelect[$mes] ?? 'Mes' }}</span>
                    </div>

                    <div class="report-chart-box">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="report-panel mb-5">
                <div class="report-panel-title-row">
                    <div class="report-panel-title">
                        <div class="report-title-dot"></div>
                        <h3 class="report-panel-label">Resumen Mensual</h3>
                    </div>
                </div>

                <div class="report-chart-box report-chart-box--bar">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="report-stat-grid">
                <div class="report-stat-card">
                    <div class="report-stat-head">
                        <div class="report-icon report-icon-green">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 7l-10 10m0-10h10v10" />
                            </svg>
                        </div>
                        <div>
                            <p class="report-stat-kicker">Ingreso más elevado</p>
                            <p class="report-stat-sub">{{ $mesIngresoMasAlto }}</p>
                        </div>
                    </div>
                    <p class="report-stat-value">{{ number_format($maxIngreso, 2, ',', '.') }}€</p>
                </div>

                <div class="report-stat-card">
                    <div class="report-stat-head">
                        <div class="report-icon report-icon-red">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7m0 0H7m10 0v10" />
                            </svg>
                        </div>
                        <div>
                            <p class="report-stat-kicker">Gasto más elevado</p>
                            <p class="report-stat-sub">{{ $mesGastoMasAlto }}</p>
                        </div>
                    </div>
                    <p class="report-stat-value">{{ number_format($maxGasto, 2, ',', '.') }}€</p>
                </div>

                <div class="report-stat-card">
                    <div class="report-stat-head">
                        <div class="report-icon report-icon-green">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8L10 18l-5-5" />
                            </svg>
                        </div>
                        <div>
                            <p class="report-stat-kicker">Ingreso medio</p>
                            <p class="report-stat-sub">Mensual</p>
                        </div>
                    </div>
                    <p class="report-stat-value">{{ number_format($promedioIngresos, 2, ',', '.') }}€</p>
                </div>

                <div class="report-stat-card">
                    <div class="report-stat-head">
                        <div class="report-icon report-icon-gray">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                            </svg>
                        </div>
                        <div>
                            <p class="report-stat-kicker">Gasto medio</p>
                            <p class="report-stat-sub">Mensual</p>
                        </div>
                    </div>
                    <p class="report-stat-value">{{ number_format($promedioGastos, 2, ',', '.') }}€</p>
                </div>
            </div>

            <div class="report-info-grid">
                <div class="report-info-card">
                    <h3 class="report-info-title">Leyenda de interpretación</h3>

                    <div class="report-info-item">
                        <div class="report-info-dot report-info-dot--income"></div>
                        <div>
                            <p class="report-info-item-title">Ingresos</p>
                            <p class="report-info-item-text">
                                Representan el dinero que entra: salario, ventas, transferencias, reembolsos u otros ingresos.
                            </p>
                        </div>
                    </div>

                    <div class="report-info-item">
                        <div class="report-info-dot report-info-dot--expense"></div>
                        <div>
                            <p class="report-info-item-title">Gastos</p>
                            <p class="report-info-item-text">
                                Muestran el dinero que sale en pagos, compras, facturas, suscripciones o consumos diarios.
                            </p>
                        </div>
                    </div>

                    <div class="report-info-item">
                        <div class="report-info-dot report-info-dot--category"></div>
                        <div>
                            <p class="report-info-item-title">Distribución por categoría</p>
                            <p class="report-info-item-text">
                                Te ayuda a detectar en qué categorías concentras más gasto durante el mes seleccionado.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="report-info-card">
                    <h3 class="report-info-title">Consejos financieros</h3>

                    <div class="report-tip-grid">
                        <div class="report-tip-card">
                            <p class="report-tip-title">Controla los picos de gasto</p>
                            <p class="report-tip-text">
                                Revisa los meses en los que el gasto supera claramente al ingreso y detecta si hubo compras puntuales o gastos recurrentes.
                            </p>
                        </div>

                        <div class="report-tip-card">
                            <p class="report-tip-title">Ahorra en categorías dominantes</p>
                            <p class="report-tip-text">
                                Si una categoría ocupa gran parte del gráfico circular, ahí tienes la mejor oportunidad para ajustar tu presupuesto.
                            </p>
                        </div>

                        <div class="report-tip-card">
                            <p class="report-tip-title">Compárate mes a mes</p>
                            <p class="report-tip-text">
                                El gráfico de barras te permite ver si estás mejorando tu equilibrio financiero con el paso del tiempo.
                            </p>
                        </div>

                        <div class="report-tip-card">
                            <p class="report-tip-title">Busca estabilidad</p>
                            <p class="report-tip-text">
                                Mantener ingresos estables y gastos controlados facilita cumplir metas y reducir presión financiera.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initReportCharts) {
                window.initReportCharts({
                    mesesLabels: @json($mesesNombres),
                    ingresosMensuales: @json($ingresosMensuales),
                    gastosMensuales: @json($gastosMensuales),
                    categoriasLabels: @json($categoriasLabels),
                    categoriasTotales: @json($categoriasTotales),
                });
            }
        });
    </script>
</x-app-layout>