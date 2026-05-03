<x-guest-layout>
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
                <h2 class="text-[15px] font-semibold mb-4">Verificar correo electrónico</h2>

                <p class="text-[11px] text-gray-300 mb-5">
                    ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el correo, te enviaremos otro con gusto.
                </p>

                <div class="space-y-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-green-500 hover:bg-green-400 text-black font-semibold py-3 text-sm transition">
                            Reenviar correo de verificación
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl border border-white/10 bg-white/5 text-gray-300 hover:text-white font-medium py-3 text-sm transition">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
