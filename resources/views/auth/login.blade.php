<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.05) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
    </style>

    <div class="min-h-screen bg-[#020806] text-white flex items-center justify-center px-4 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 w-[320px] h-[320px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-green-500/10 blur-3xl"></div>
            <div class="absolute top-24 left-1/3 w-40 h-40 rounded-full bg-emerald-400/5 blur-3xl"></div>
            <div class="absolute bottom-20 right-1/3 w-44 h-44 rounded-full bg-green-400/5 blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-[360px]">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold tracking-wide text-green-400">KWALY</h1>
                <p class="text-[11px] text-gray-400 mt-1">Gestión Financiera Personal</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl px-5 py-6">
                <h2 class="text-[15px] font-semibold mb-5">Iniciar Sesión</h2>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-[11px] text-gray-300 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Introduce tu correo electrónico"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none focus:border-green-400 focus:outline-none focus:ring-0 appearance-none shadow-none"
                            />
                        </div>
                        @error('email')
                            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] text-gray-300 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Introduce tu contraseña"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none focus:border-green-400 focus:outline-none focus:ring-0 appearance-none shadow-none"
                            />
                        </div>
                        @error('password')
                            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <label for="remember_me" class="flex items-center gap-2 text-gray-300">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-gray-600 bg-transparent text-green-500 focus:ring-green-400"
                                name="remember"
                            >
                            <span>Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                class="text-green-400 hover:text-green-300 transition"
                                href="{{ route('password.request') }}"
                            >
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-500 hover:bg-green-400 text-black font-semibold py-3 text-sm transition"
                    >
                        Iniciar Sesión
                    </button>

                    <div class="text-center text-[11px] text-gray-400 pt-1">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-medium">
                            Regístrate
                        </a>
                    </div>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-transparent px-3 text-[10px] text-gray-500">O continúa con</span>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="w-full rounded-xl border border-white/10 bg-white/5 py-3 text-sm text-gray-300 hover:bg-white/10 transition"
                    >
                        Google
                    </button>
                </form>
            </div>

            <div class="text-center text-[10px] text-gray-500 mt-4">
                Al continuar, aceptas nuestros
                <a href="#" class="text-green-400 hover:text-green-300">Términos de Servicio</a>
                y
                <a href="#" class="text-green-400 hover:text-green-300">Política de Privacidad</a>
            </div>
        </div>
    </div>
</x-guest-layout>