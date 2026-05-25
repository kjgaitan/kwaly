<x-app-layout>
    @php
        $miembrosResumenFormulario = $miembros->map(fn($miembro) => [
            'id' => $miembro->id_usuario,
            'nombre' => $miembro->usuario?->nombre ?? 'Usuario sin nombre',
        ])->values();
    @endphp

    <div class="compartido-page"
        x-data="{
            monto: '{{ old('monto_total', '') }}',
            pagador: '{{ old('id_usuario_pagador', auth()->user()->id_usuario) }}',
            miembros: {{ \Illuminate\Support\Js::from($miembrosResumenFormulario) }},
            get total() {
                const value = Number.parseFloat(String(this.monto).replace(',', '.'));
                return Number.isFinite(value) && value > 0 ? value : 0;
            },
            get cantidadMiembros() {
                return this.miembros.length;
            },
            get cuota() {
                return this.cantidadMiembros > 0 ? this.total / this.cantidadMiembros : 0;
            },
            get nombrePagador() {
                return this.miembros.find((miembro) => String(miembro.id) === String(this.pagador))?.nombre || 'Seleccione un miembro';
            },
            format(value) {
                return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(value || 0);
            }
        }">
        <div class="compartido-container">
            <div class="compartido-header">
                <div>
                    <a href="{{ route('compartido.index') }}" class="compartido-back-link">
                        <i class="bi bi-arrow-left"></i>
                        Volver a cuenta compartida
                    </a>

                    <h1 class="compartido-title mt-4">Registrar gasto</h1>
                    <p class="compartido-subtitle">
                        Agrega un gasto y revisa como se divide antes de guardarlo.
                    </p>
                </div>
            </div>

            <div class="compartido-form-layout">
                @include('compartido.partials.form-gasto', ['grupo' => $grupo, 'miembros' => $miembros])

                <aside class="compartido-share-card">
                    <h2 class="compartido-form-title">Resumen del reparto</h2>

                    <div class="compartido-share-lines">
                        <div>
                            <span>Total</span>
                            <strong x-text="format(total)"></strong>
                        </div>
                        <div>
                            <span>Miembros</span>
                            <strong x-text="cantidadMiembros"></strong>
                        </div>
                        <div>
                            <span>Cada persona paga</span>
                            <strong x-text="format(cuota)"></strong>
                        </div>
                        <div>
                            <span>Pagado por</span>
                            <strong x-text="nombrePagador"></strong>
                        </div>
                    </div>

                    <div class="compartido-share-result">
                        <template x-if="total <= 0">
                            <p>Ingresa un monto para calcular el reparto.</p>
                        </template>

                        <template x-if="total > 0">
                            <div class="space-y-2">
                                <template x-for="miembro in miembros" :key="miembro.id">
                                    <p>
                                        <template x-if="String(miembro.id) === String(pagador)">
                                            <span>
                                                <strong x-text="miembro.nombre"></strong>
                                                adelantó <strong x-text="format(total - cuota)"></strong>
                                            </span>
                                        </template>
                                        <template x-if="String(miembro.id) !== String(pagador)">
                                            <span>
                                                <strong x-text="miembro.nombre"></strong>
                                                debe <strong x-text="format(cuota)"></strong>
                                            </span>
                                        </template>
                                    </p>
                                </template>
                            </div>
                        </template>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
