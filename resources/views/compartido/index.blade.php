<x-app-layout>
    <div class="compartido-page" x-data="{
        inviteOpen: {{ $errors->has('id_usuario') ? 'true' : 'false' }},
        showInviteErrors: {{ $errors->has('id_usuario') ? 'true' : 'false' }},
        closeInviteModal() {
            this.inviteOpen = false;
            this.showInviteErrors = false;

            this.$nextTick(() => {
                if (this.$refs.inviteUser) {
                    this.$refs.inviteUser.value = '';
                }
            });
        }
    }">
        <div class="compartido-container">

            <div class="compartido-header">
                <div>
                    <h1 class="compartido-title">Cuenta Compartida</h1>
                    <p class="compartido-subtitle">Gestion financiera colaborativa</p>
                </div>

                @if($grupo)
                    <div class="compartido-header-actions">
                        @if($puedeRegistrarGasto)
                            <a href="{{ route('compartido.gastos.create') }}" class="compartido-btn-secondary-inline">
                                <i class="bi bi-receipt"></i>
                                Registrar gasto
                            </a>
                        @endif

                        @if($esAdminGrupo)
                            <button type="button" class="compartido-btn-primary" @click="inviteOpen = true">
                                <i class="bi bi-plus-lg"></i>
                                Invitar miembro
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            @if(!$grupo)
                @include('compartido.partials.empty-state')
            @else
                @include('compartido.partials.resumen')

                <div class="mb-8">
                    @include('compartido.partials.miembros')
                </div>

                <div class="mb-8">
                    @include('compartido.partials.gastos')
                </div>

                @include('compartido.partials.leyenda')

                @if($esAdminGrupo)
                    <div x-cloak
                        x-show="inviteOpen"
                        x-transition.opacity
                        class="compartido-modal-backdrop"
                        @keydown.escape.window="closeInviteModal()">
                        <div class="compartido-modal-panel"
                            x-show="inviteOpen"
                            x-transition
                            @click.outside="closeInviteModal()">
                            <div class="compartido-modal-header">
                                <div>
                                    <h2 class="compartido-form-title">Invitar miembro</h2>
                                    <p class="compartido-modal-subtitle">Agrega un usuario existente al grupo.</p>
                                </div>

                                <button type="button" class="compartido-icon-button" @click="closeInviteModal()">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            @include('compartido.partials.form-miembro', ['grupo' => $grupo, 'usuariosDisponibles' => $usuariosDisponibles])
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
