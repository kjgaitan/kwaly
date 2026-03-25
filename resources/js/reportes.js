import Chart from 'chart.js/auto';

export function initReportCharts(data) {
    const {
        mesesLabels,
        ingresosMensuales,
        gastosMensuales,
        categoriasLabels,
        categoriasTotales
    } = data;

    const chartTextColor = '#d1d5db';
    const chartGridColor = 'rgba(255,255,255,0.08)';

    const lineCtx = document.getElementById('lineChart');

    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: mesesLabels,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: ingresosMensuales,
                        borderColor: '#6ee7b7',
                        backgroundColor: 'rgba(110, 231, 183, 0.15)',
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#a7f3d0',
                        pointBorderColor: '#6ee7b7',
                        fill: false
                    },
                    {
                        label: 'Gastos',
                        data: gastosMensuales,
                        borderColor: '#ff5a5a',
                        backgroundColor: 'rgba(255, 90, 90, 0.15)',
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#fecaca',
                        pointBorderColor: '#ff5a5a',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        labels: {
                            color: chartTextColor,
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6b7280'
                        },
                        grid: {
                            color: chartGridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6b7280'
                        },
                        grid: {
                            color: chartGridColor
                        }
                    }
                }
            }
        });
    }

    const doughnutCtx = document.getElementById('doughnutChart');

    if (doughnutCtx) {
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: categoriasLabels.length ? categoriasLabels : ['Sin gastos registrados'],
                datasets: [
                    {
                        data: categoriasTotales.length ? categoriasTotales : [1],
                        backgroundColor: categoriasTotales.length
                            ? ['#5eead4', '#4ade80', '#22c55e', '#15803d', '#14532d', '#86efac', '#34d399', '#10b981']
                            : ['#1f2937'],
                        borderColor: '#101512',
                        borderWidth: 2,
                        hoverOffset: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: chartTextColor,
                            padding: 14,
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    }
                }
            }
        });
    }

    const barCtx = document.getElementById('barChart');

    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: mesesLabels,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: ingresosMensuales,
                        backgroundColor: '#2f7f4f',
                        borderRadius: 6
                    },
                    {
                        label: 'Gastos',
                        data: gastosMensuales,
                        backgroundColor: '#ff5252',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: chartTextColor,
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            color: '#6b7280'
                        },
                        grid: {
                            color: chartGridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6b7280'
                        },
                        grid: {
                            color: chartGridColor
                        }
                    }
                }
            }
        });
    }
}