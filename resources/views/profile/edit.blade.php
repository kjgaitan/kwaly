<x-app-layout>
    <div class="config-wrapper">
        <div class="config-container">

            <div class="config-header">
                <h1>Perfil de usuario</h1>
                <p>Actualiza tus datos personales y tu contrasena de acceso.</p>
            </div>

            @if(session('success'))
                <div class="config-alert-success">
                    {{ session('success') }}
                </div>
            @endif

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
                        @error('nombre')
                            <small class="config-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="config-form-group">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}">
                        @error('email')
                            <small class="config-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="config-form-group">
                        <label for="telefono">Telefono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}">
                        @error('telefono')
                            <small class="config-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="config-form">
                        <div class="config-form-group">
                            <label for="password_actual">Contrasena actual</label>
                            <input type="password" id="password_actual" name="password_actual" autocomplete="current-password">
                            @error('password_actual')
                                <small class="config-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="config-form-group">
                            <label for="password_nueva">Nueva contrasena</label>
                            <input type="password" id="password_nueva" name="password_nueva" autocomplete="new-password">
                            @error('password_nueva')
                                <small class="config-error">{{ $message }}</small>
                            @enderror
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
