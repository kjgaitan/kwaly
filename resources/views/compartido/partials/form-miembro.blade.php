<div id="form-miembro" class="compartido-form-card">
    <h2 class="compartido-form-title">Invitar Miembro</h2>

    <form action="{{ route('compartido.miembro.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        <div class="compartido-form-group">
            <label for="email" class="compartido-label">Correo del usuario</label>
            <input type="email"
                   name="email"
                   id="email"
                   value="{{ old('email') }}"
                   placeholder="correo@gmail.com"
                   class="compartido-input {{ $errors->has('email') ? 'border-red-500' : '' }}">
            @if($errors->has('email'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="compartido-form-group">
            <label for="rol" class="compartido-label">Rol</label>
            <select name="rol" id="rol" class="compartido-select dark-select {{ $errors->has('rol') ? 'border-red-500' : '' }}">
                <option value="" disabled {{ old('rol') === '' ? 'selected' : '' }}>Seleccione un rol</option>
                <option value="miembro" {{ old('rol') === 'miembro' ? 'selected' : '' }}>Miembro</option>
                <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @if($errors->has('rol'))
                <p class="mt-2 text-xs text-red-400">{{ $errors->first('rol') }}</p>
            @endif
        </div>

        <button type="submit" class="compartido-btn-submit">
            Agregar miembro
        </button>
    </form>
</div>