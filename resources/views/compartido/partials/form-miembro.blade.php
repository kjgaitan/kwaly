<div id="form-miembro" class="compartido-form-card">
    <h2 class="compartido-form-title">Invitar Miembro</h2>

    <form action="{{ route('compartido.miembro.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        <div class="compartido-form-group">
            <label for="email" class="compartido-label">Correo del usuario</label>
            <input type="email"
                   name="email"
                   id="email"
                   value="{{ old('email') }}"
                   placeholder="correo@ejemplo.com"
                   class="compartido-input">
        </div>

        <div class="compartido-form-group">
            <label for="rol" class="compartido-label">Rol</label>
            <select name="rol" id="rol" class="compartido-select dark-select">
                <option value="miembro">Miembro</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="compartido-btn-submit">
            Agregar miembro
        </button>
    </form>
</div>