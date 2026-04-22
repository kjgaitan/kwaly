<aside class="hidden md:flex fixed top-0 left-0 h-screen w-64 bg-[#0a0f0d] border-r border-white/5 flex-col">
    <div class="px-6 py-5 border-b border-white/5">
        <h1 class="text-2xl font-bold tracking-wide text-green-400">KWALY</h1>
        <p class="text-xs text-gray-400 mt-1">Gestión Financiera Personal</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-grid text-base"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('transacciones.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('transacciones.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-arrow-left-right text-base"></i>
            <span>Transacciones</span>
        </a>

        <a href="{{ route('presupuestos.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('presupuestos.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-wallet text-base"></i>
            <span>Presupuestos</span>
        </a>

        <a href="{{ route('facturas.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('facturas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-file-earmark-text text-base"></i>
            <span>Facturas</span>
        </a>
{{--
        <a href="{{ route('asistente.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('asistente.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-chat-left-text text-base"></i>
            <span>Asistente</span>
        </a>
--}}
        <a href="{{ route('educacion.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('educacion.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-book text-base"></i>
            <span>Educación</span>
        </a>

        <a href="{{ route('calendario.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('calendario.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-calendar4-week text-base"></i>
            <span>Calendario</span>
        </a>

        <a href="{{ route('metas.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('metas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-trophy text-base"></i>
            <span>Metas</span>
        </a>

        <a href="{{ route('reportes.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('reportes.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-bar-chart text-base"></i>
            <span>Reportes</span>
        </a>

        <a href="{{ route('compartido.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('compartido.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-people text-base"></i>
            <span>Compartido</span>
        </a>
{{--
        <a href="{{ route('configuracion.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('configuracion.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-gear text-base"></i>
            <span>Configuración</span>
        </a>
    </nav>
--}}
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