<h2 class="compartido-section-title">Miembros del Grupo</h2>

<div class="compartido-grid-miembros">
    @foreach($miembrosResumen as $miembro)
        @php
            $balanceClase = $miembro['balance'] > 0
                ? 'compartido-text-green'
                : ($miembro['balance'] < 0 ? 'compartido-text-red' : 'compartido-text-neutral');
            $balanceSigno = $miembro['balance'] > 0 ? '+' : '';
        @endphp

        <div class="compartido-card compartido-card-padding compartido-member-card-simple">
            <div class="compartido-member-header">
                <div class="compartido-member-info">
                    <div class="compartido-member-avatar">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <h3 class="compartido-member-name">
                            {{ $miembro['nombre'] }}
                            @if(auth()->user()->id_usuario === $miembro['id_usuario'])
                                <span class="compartido-member-you">Tu</span>
                            @endif
                        </h3>
                        <p class="compartido-member-email">{{ $miembro['email'] }}</p>
                    </div>
                </div>

                <span class="compartido-badge {{ $miembro['rol'] === 'admin' ? 'compartido-badge-admin' : 'compartido-badge-member' }}">
                    {{ ucfirst($miembro['rol']) }}
                </span>
            </div>

            <div class="compartido-member-balance-row">
                <span>Balance</span>
                <strong class="{{ $balanceClase }}">
                    {{ $balanceSigno }}{{ number_format($miembro['balance'], 0, ',', '.') }}€
                </strong>
            </div>

            <div class="compartido-member-mini-stats">
                <span>Aportado: <strong>{{ number_format($miembro['aportado'], 0, ',', '.') }}€</strong></span>
                <span>Gastado: <strong>{{ number_format($miembro['gastado'], 0, ',', '.') }}€</strong></span>
            </div>
            @if(($esAdminGrupo ?? false) && auth()->user()->id_usuario !== $miembro['id_usuario'])
                <form action="{{ route('compartido.miembro.destroy', $miembro['id_miembro']) }}" method="POST" class="compartido-member-delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="compartido-action-button compartido-action-danger">
                        <i class="bi bi-trash"></i>
                        Borrar miembro
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
