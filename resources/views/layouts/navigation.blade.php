<aside class="hidden md:flex fixed top-0 left-0 h-screen w-64 bg-[#0a0f0d] border-r border-white/5 flex-col">
    <div class="px-6 py-5 border-b border-white/5">
        <h1 class="text-2xl font-bold tracking-wide text-green-400">KWALY</h1>
        <p class="text-xs text-gray-400 mt-1">Gestión Financiera Personal</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            Dashboard
        </a>

        <a href="{{ route('transacciones.index') }}"
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('transacciones.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            Transacciones
        </a>

        <a href="{{ route('presupuestos.index') }}"
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('presupuestos.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            Presupuestos
        </a>

        <a href="{{ route('calendario.index') }}"
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('facturas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            Calendario
        </a>

        <a href="{{ route('reportes.index') }}"
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('metas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            Reportes
        </a>

    </nav>

    <div class="px-4 py-4 border-t border-white/5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white px-4 py-3 text-sm transition">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>