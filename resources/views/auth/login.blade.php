<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen bg-[#020806] text-white flex items-center justify-center px-4 relative overflow-hidden">

        <!-- Fondo decorativo -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 w-[320px] h-[320px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-green-500/10 blur-3xl"></div>
            <div class="absolute top-24 left-1/3 w-40 h-40 rounded-full bg-emerald-400/5 blur-3xl"></div>
            <div class="absolute bottom-20 right-1/3 w-44 h-44 rounded-full bg-green-400/5 blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-[360px]">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold tracking-wide text-green-400">
                    {{ __('navigation.app_name') }}
                </h1>
                <p class="text-[11px] text-gray-400 mt-1">
                    {{ __('navigation.subtitle') }}
                </p>
            </div>

            <!-- Card -->
            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl px-5 py-6">
                
                <h2 class="text-[15px] font-semibold mb-5">
                    {{ __('login.title') }}
                </h2>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-[11px] text-gray-300 mb-2">
                            {{ __('login.email') }}
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="{{ __('login.email_placeholder') }}"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none focus:border-green-400"
                        />

                        @error('email')
                            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-[11px] text-gray-300 mb-2">
                            {{ __('login.password_label') }}
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="{{ __('login.password_placeholder') }}"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none focus:border-green-400"
                        />

                        @error('password')
                            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Forgot -->
                    <div class="flex justify-end text-[11px] pt-1">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-green-400 hover:text-green-300 transition">
                                {{ __('login.forgot') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-500 hover:bg-green-400 text-black font-semibold py-3 text-sm transition"
                    >
                        {{ __('login.title') }}
                    </button>

                    <!-- Register -->
                    <div class="text-center text-[11px] text-gray-400 pt-1">
                        {{ __('login.no_account') }}
                        <a href="{{ route('register') }}"
                           class="text-green-400 hover:text-green-300 font-medium">
                            {{ __('login.register') }}
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-3 text-[10px] text-gray-500">
                                {{ __('login.or_continue') }}
                            </span>
                        </div>
                    </div>

                    <!-- Google -->
                    <button
                        type="button"
                        class="w-full rounded-xl border border-white/10 bg-white/5 py-3 text-sm text-gray-300 hover:bg-white/10 transition"
                    >
                        Google
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center text-[10px] text-gray-500 mt-4">
                {{ __('login.terms_text') }}
                <a href="#" class="text-green-400 hover:text-green-300">
                    {{ __('login.terms') }}
                </a>
                {{ __('login.and') }}
                <a href="#" class="text-green-400 hover:text-green-300">
                    {{ __('login.privacy') }}
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
