<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KWALY</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <script>
    (function() {
        const isDesktop = window.matchMedia('(min-width: 768px)').matches;
        const saved = localStorage.getItem('kwaly_sidebar_open');

        const sidebarOpen = isDesktop ?
            (saved === null ? true : JSON.parse(saved)) :
            false;

        document.documentElement.classList.toggle('sidebar-open', sidebarOpen);
        document.documentElement.classList.toggle('sidebar-closed', !sidebarOpen);
    })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#020806] text-white" x-data="{
        sidebarOpen: document.documentElement.classList.contains('sidebar-open'),

        toggleSidebar() {
            if (window.innerWidth < 768) return;

            this.sidebarOpen = !this.sidebarOpen;

            document.documentElement.classList.toggle('sidebar-open', this.sidebarOpen);
            document.documentElement.classList.toggle('sidebar-closed', !this.sidebarOpen);

            localStorage.setItem('kwaly_sidebar_open', JSON.stringify(this.sidebarOpen));
        },

        checkScreen() {
            if (window.innerWidth < 768) {
                this.sidebarOpen = false;

                document.documentElement.classList.remove('sidebar-open');
                document.documentElement.classList.add('sidebar-closed');
            } else {
                const saved = localStorage.getItem('kwaly_sidebar_open');
                this.sidebarOpen = saved === null ? true : JSON.parse(saved);

                document.documentElement.classList.toggle('sidebar-open', this.sidebarOpen);
                document.documentElement.classList.toggle('sidebar-closed', !this.sidebarOpen);
            }
        }
    }" x-init="window.addEventListener('resize', () => checkScreen())">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main class="kwaly-main min-h-screen bg-[#020806]">

            <div
                class="kwaly-topbar fixed top-0 right-0 z-50 flex items-center justify-between gap-4 border-b border-[#26352d] bg-[#020806]/95 px-3 py-2 backdrop-blur lg:px-6">

                <button type="button" @click="toggleSidebar()"
                    class="hidden md:flex h-10 w-10 items-center justify-center rounded-xl border border-[#26352d] bg-[#111613] text-white transition hover:border-[#72f59a]/40 hover:bg-[#182019]"
                    title="Expandir o contraer menÃº">
                    <i class="bi text-xl"
                        :class="sidebarOpen ? 'bi-layout-sidebar-inset' : 'bi-layout-sidebar-inset-reverse'"></i>
                </button>

                <div class="md:hidden"></div>

                <div class="flex items-center gap-4">
                    <button
                        class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#26352d] bg-[#111613] transition hover:bg-[#1a211d]">
                        <i class="bi bi-bell text-lg"></i>
                        <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-[#72f59a]"></span>
                    </button>

                    <x-dropdown align="right" width="48" contentClasses="py-1 bg-[#111613]">
                        <x-slot name="trigger">
                            <button type="button"
                                class="flex items-center gap-3 rounded-xl border border-[#26352d] bg-[#111613] px-3 py-2 transition hover:border-[#72f59a]/40 hover:bg-[#182019]">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-[#72f59a] font-bold text-black">
                                    {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nombre ?? 'U', 0, 1)) }}
                                </div>

                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium text-white">
                                        {{ Auth::user()->name ?? Auth::user()->nombre ?? 'Usuario' }}
                                    </p>
                                </div>

                                <i class="bi bi-chevron-down text-sm text-white/80"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <a href="{{ route('profile.edit') }}"
                                class="flex w-full items-center gap-2 px-4 py-2 text-start text-sm text-white transition hover:bg-[#182019]">
                                <i class="bi bi-person"></i>
                                <span>Perfil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-start text-sm text-white transition hover:bg-[#182019]">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Cerrar sesión</span>
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="px-2 py-2 pt-16 sm:px-3 lg:px-4">
                <x-flash-messages />
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
