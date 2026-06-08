<div id="form-miembro">
    <form action="{{ route('compartido.miembro.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">
        <input type="hidden" name="rol" value="miembro">

        <div class="compartido-form-group">
            <label for="id_usuario" class="compartido-label">Usuario</label>
            <select name="id_usuario"
                id="id_usuario"
                x-ref="inviteUser"
                class="compartido-select dark-select"
                :class="showInviteErrors ? '{{ $errors->has('id_usuario') ? 'border-red-500' : '' }}' : ''">
                <option value="">Seleccione un usuario</option>
                @foreach($usuariosDisponibles as $usuarioDisponible)
                    <option value="{{ $usuarioDisponible->id_usuario }}" {{ (string) old('id_usuario') === (string) $usuarioDisponible->id_usuario ? 'selected' : '' }}>
                        {{ $usuarioDisponible->nombre }} - {{ $usuarioDisponible->email }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('id_usuario'))
                <p class="mt-2 text-xs text-red-400" x-show="showInviteErrors">{{ $errors->first('id_usuario') }}</p>
            @endif

            @if($usuariosDisponibles->isEmpty())
                <p class="mt-2 text-xs text-gray-500">No hay usuarios disponibles para anadir a esta cuenta compartida.</p>
            @endif
        </div>

        <div class="compartido-role-note">
            <i class="bi bi-shield-check"></i>
            <span>Los nuevos usuarios entran como miembros. Solo un administrador puede gestionar permisos y miembros.</span>
        </div>

        <button type="submit" class="compartido-btn-submit" {{ $usuariosDisponibles->isEmpty() ? 'disabled' : '' }}>
            Agregar miembro
        </button>
    </form>
</div>
