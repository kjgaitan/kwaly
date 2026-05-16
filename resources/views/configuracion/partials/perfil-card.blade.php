<div class="config-card">
    <div class="config-card-title">
        <div class="config-icon green">
            <i class="bi bi-person"></i>
        </div>

        <h2>{{ __('configuracion.perfil.title') }}</h2>
    </div>

    <form action="{{ route('configuracion.perfil.update') }}"
          method="POST"
          class="config-form">

        @csrf
        @method('PUT')

        <div class="config-form-group">
            <label for="nombre">
                {{ __('configuracion.perfil.nombre') }}
            </label>

            <input type="text"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre', $usuario->nombre) }}">

            <x-input-error :messages="$errors->get('nombre')" />
        </div>

        <div class="config-form-group">
            <label for="email">
                {{ __('configuracion.perfil.email') }}
            </label>

            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $usuario->email) }}">

            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="config-form-group">
            <label for="telefono">
                {{ __('configuracion.perfil.telefono') }}
            </label>

            <input type="text"
                   id="telefono"
                   name="telefono"
                   value="{{ old('telefono', $usuario->telefono) }}">

            <x-input-error :messages="$errors->get('telefono')" />
        </div>

        <div class="config-form-group">
            <label for="password_actual">
                {{ __('configuracion.seguridad.password_actual') }}
            </label>

            <input type="password"
                   id="password_actual"
                   name="password_actual">

            <x-input-error :messages="$errors->get('password_actual')" />
        </div>

        <div class="config-form-group">
            <label for="password_nueva">
                {{ __('configuracion.seguridad.password_nueva') }}
            </label>

            <input type="password"
                   id="password_nueva"
                   name="password_nueva">

            <x-input-error :messages="$errors->get('password_nueva')" />
        </div>

        <div class="config-form-group">
            <label for="password_nueva_confirmation">
                {{ __('configuracion.seguridad.password_confirmacion') }}
            </label>

            <input type="password"
                   id="password_nueva_confirmation"
                   name="password_nueva_confirmation">
        </div>

        <div class="mt-8 flex items-center justify-end gap-3 pr-2 pb-2">

            <a href="{{ route('dashboard') }}"
               class="profile-btn-cancel">
                Cancelar
            </a>

            <button type="submit"
                    class="config-btn-primary">
                {{ __('configuracion.perfil.guardar') }}
            </button>

        </div>

    </form>
</div>