<x-app-layout>
    <div class="config-wrapper">
        <div class="config-container">

            <div class="config-header">
                <h1>Perfil de usuario</h1>
                <p>Actualiza tus datos personales y tu contrasena de acceso.</p>
            </div>

            <div class="config-card">
                <div class="config-card-title">
                    <div class="config-icon green">
                        <i class="bi bi-person"></i>
                    </div>
                    <h2>Perfil</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="config-form">
                    @csrf
                    @method('PUT')

                    <div class="config-form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
                        <x-input-error :messages="$errors->get('nombre')" />

                    </div>

                    <div class="config-form-group">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}">
                        <x-input-error :messages="$errors->get('email')" />

                    </div>

                    <div class="config-form-group">
                        <label for="telefono">Telefono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}">
                        <x-input-error :messages="$errors->get('telefono')" />

                    </div>

                    <div class="config-form">
                        <div class="config-form-group">
                            <label for="password_actual">Contrasena actual</label>
                            <input type="password" id="password_actual" name="password_actual" autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password_actual')" />

                        </div>

                        <div class="config-form-group">
                            <label for="password_nueva">Nueva contrasena</label>
                            <input type="password" id="password_nueva" name="password_nueva" autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_nueva')" />

                        </div>

                        <div class="config-form-group">
                            <label for="password_nueva_confirmation">Confirmar nueva contrasena</label>
                            <input type="password" id="password_nueva_confirmation" name="password_nueva_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="config-btn-primary">
                            Guardar cambios
                        </button>

                        <a href="{{ route('dashboard') }}" class="profile-btn-cancel">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
