<div id="form-miembro">
    <form action="{{ route('compartido.miembro.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

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

        <div class="compartido-form-group">
            <label for="rol" class="compartido-label">Rol</label>
            <select name="rol" id="rol" x-ref="inviteRol" class="compartido-select dark-select"
                :class="showInviteErrors ? '{{ $errors->has('rol') ? 'border-red-500' : '' }}' : ''">
                <option value="" disabled {{ old('rol') === '' ? 'selected' : '' }}>Seleccione un rol</option>
                <option value="miembro" {{ old('rol', 'miembro') === 'miembro' ? 'selected' : '' }}>Miembro</option>
                <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @if($errors->has('rol'))
                <p class="mt-2 text-xs text-red-400" x-show="showInviteErrors">{{ $errors->first('rol') }}</p>
            @endif
        </div>

        <button type="submit" class="compartido-btn-submit" {{ $usuariosDisponibles->isEmpty() ? 'disabled' : '' }}>
            Agregar miembro
        </button>
    </form>
</div>
