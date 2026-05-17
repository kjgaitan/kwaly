<aside class="kwaly-sidebar fixed left-0 top-0 z-50 flex h-screen flex-col border-r border-white/5 bg-[#0a0f0d]">

    <div class="flex h-[73px] items-center border-b border-white/5"
        :class="sidebarOpen ? 'px-4 justify-start' : 'justify-center'">

        <div class="w-full">

            <h1 class="font-bold tracking-wide text-green-400 transition-all duration-300" :class="sidebarOpen
                ? 'text-2xl text-left'
                : 'text-sm text-center leading-[73px]'">
                {{ __('navigation.app_name') }}
            </h1>

            <p x-show="sidebarOpen" class="kwaly-sidebar-subtitle mt-1 text-xs text-gray-400">
                {{ __('navigation.subtitle') }}
            </p>

        </div>

    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto overflow-x-hidden px-3 py-6 text-sm">

        <a href="{{ route('dashboard') }}" title="{{ __('navigation.dashboard') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-grid text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.dashboard') }}</span>
        </a>

        <a href="{{ route('transacciones.index') }}" title="{{ __('navigation.transacciones') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('transacciones.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-arrow-left-right text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.transacciones') }}</span>
        </a>

        <a href="{{ route('presupuestos.index') }}" title="{{ __('navigation.presupuestos') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('presupuestos.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-wallet text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.presupuestos') }}</span>
        </a>

        <a href="{{ route('facturas.index') }}" title="{{ __('navigation.facturas') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('facturas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-file-earmark-text text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.facturas') }}</span>
        </a>

        <a href="{{ route('educacion.index') }}" title="{{ __('navigation.educacion') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('educacion.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-book text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.educacion') }}</span>
        </a>

        <a href="{{ route('calendario.index') }}" title="{{ __('navigation.calendario') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('calendario.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-calendar4-week text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.calendario') }}</span>
        </a>

        <a href="{{ route('metas.index') }}" title="{{ __('navigation.metas') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('metas.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-trophy text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.metas') }}</span>
        </a>

        <a href="{{ route('reportes.index') }}" title="{{ __('navigation.reportes') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('reportes.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-bar-chart text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.reportes') }}</span>
        </a>

        <a href="{{ route('compartido.index') }}" title="{{ __('navigation.compartido') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('compartido.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-people text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.compartido') }}</span>
        </a>

        <a href="{{ route('configuracion.index') }}" title="{{ __('navigation.configuracion') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('configuracion.*') ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <i class="bi bi-gear text-lg shrink-0"></i>
            <span class="kwaly-sidebar-text">{{ __('navigation.configuracion') }}</span>
        </a>
    </nav>

    <div class="border-t border-white/5 px-3 py-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" title="{{ __('navigation.logout') }}"
                class="flex w-full items-center gap-3 rounded-xl bg-white/5 px-4 py-3 text-sm text-gray-300 transition-colors hover:bg-white/10 hover:text-white">
                <i class="bi bi-box-arrow-right text-lg shrink-0"></i>
                <span class="kwaly-sidebar-text">{{ __('navigation.logout') }}</span>
            </button>
        </form>
    </div>
</aside>