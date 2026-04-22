<h2 class="compartido-section-title">Miembros del Grupo</h2>

<div class="compartido-grid-miembros">
    @foreach($miembrosResumen as $miembro)
        <div class="compartido-card compartido-card-padding">
            <div class="compartido-member-header">
                <div class="compartido-member-info">
                    <div class="compartido-member-avatar">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <h3 class="compartido-member-name">
                            {{ $miembro['nombre'] }}
                            @if(auth()->user()->id_usuario === $miembro['id_usuario'])
                                <span class="compartido-member-you">Tú</span>
                            @endif
                        </h3>
                        <p class="compartido-member-email">{{ $miembro['email'] }}</p>
                    </div>
                </div>

                <span class="compartido-badge {{ $miembro['rol'] === 'admin' ? 'compartido-badge-admin' : 'compartido-badge-member' }}">
                    {{ ucfirst($miembro['rol']) }}
                </span>
            </div>

            <div class="compartido-member-stats">
                <div class="compartido-member-box compartido-member-box-green">
                    <span class="compartido-member-box-label">Aportado:</span>
                    <span class="compartido-member-box-value compartido-text-green">
                        {{ number_format($miembro['aportado'], 0, ',', '.') }}€
                    </span>
                </div>

                <div class="compartido-member-box compartido-member-box-red">
                    <span class="compartido-member-box-label">Gastado:</span>
                    <span class="compartido-member-box-value compartido-text-red">
                        {{ number_format($miembro['gastado'], 0, ',', '.') }}€
                    </span>
                </div>

                <div class="compartido-member-box compartido-member-box-neutral">
                    <span class="compartido-member-box-label">Balance:</span>
                    <span class="compartido-member-box-value {{ $miembro['balance'] >= 0 ? 'compartido-text-green' : 'compartido-text-red' }}">
                        {{ number_format($miembro['balance'], 0, ',', '.') }}€
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>
   

