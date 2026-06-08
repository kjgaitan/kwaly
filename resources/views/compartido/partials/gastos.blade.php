<h2 class="compartido-section-title">Gastos Compartidos Recientes</h2>

<div class="compartido-gastos-list">
    @forelse($gastos as $gasto)
        @php
            $numeroParticipantes = $gasto->participantes->count();
            $porPersona = $numeroParticipantes > 0 ? $gasto->monto_total / $numeroParticipantes : 0;
            $puedeEliminarGasto = ($esAdminGrupo ?? false) || (int) $gasto->id_usuario_pagador === (int) auth()->user()->id_usuario;
            $categoria = $gasto->categoriaRelacion;
        @endphp

        <div class="compartido-gasto-item" x-data="{ detailOpen: false }">
            <div class="compartido-gasto-content">
                <div class="compartido-gasto-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h3>{{ $gasto->titulo }}</h3>

                        <span class="compartido-badge compartido-badge-admin">
                            {{ $categoria?->nombre ?? $gasto->categoria ?? 'Compartido' }}
                        </span>
                    </div>

                    <p class="compartido-gasto-meta">
                        Pagado por {{ $gasto->pagador?->nombre ?? 'Usuario' }}
                        <span class="mx-2 text-gray-600">/</span>
                        {{ optional($gasto->fecha_gasto)->format('d/m/Y') }}
                    </p>

                    @if($gasto->descripcion)
                        <p class="compartido-gasto-description">{{ $gasto->descripcion }}</p>
                    @endif
                </div>

                <div class="compartido-gasto-right">
                    <p class="compartido-gasto-total">
                        {{ number_format($gasto->monto_total, 0, ',', '.') }} EUR
                    </p>
                    <p class="compartido-gasto-extra">
                        {{ number_format($porPersona, 2, ',', '.') }} EUR por persona
                    </p>

                    <div class="compartido-gasto-actions">
                        <button type="button" class="compartido-action-button" @click="detailOpen = !detailOpen">
                            Ver detalle
                        </button>

                        @if($puedeEliminarGasto)
                            <form action="{{ route('compartido.gasto.destroy', $gasto->id_gasto) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="compartido-action-button compartido-action-danger">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div x-cloak x-show="detailOpen" x-transition class="compartido-gasto-detail">
                <p>Total: <strong>{{ number_format($gasto->monto_total, 2, ',', '.') }} EUR</strong></p>
                <p>Participantes: <strong>{{ $numeroParticipantes }}</strong></p>
                <p>Cada persona paga: <strong>{{ number_format($porPersona, 2, ',', '.') }} EUR</strong></p>
                <p>{{ $gasto->pagador?->nombre ?? 'El pagador' }} adelanto <strong>{{ number_format(max($gasto->monto_total - $porPersona, 0), 2, ',', '.') }} EUR</strong></p>
                @if($numeroParticipantes > 0)
                    <p>
                        Repartido entre:
                        <strong>{{ $gasto->participantes->map(fn($participante) => $participante->usuario?->nombre)->filter()->join(', ') }}</strong>
                    </p>
                @endif
            </div>
        </div>
    @empty
        <div class="compartido-card compartido-card-padding text-gray-400">
            No hay gastos compartidos registrados todavia.
        </div>
    @endforelse
</div>
