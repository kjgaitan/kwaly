<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KWALY</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- BOOTSTRAP ICONS (ESTO ES LO QUE TE FALTABA) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#020806] text-white">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main class="md:ml-64 min-h-screen bg-[#020806]">

            <!-- HEADER SUPERIOR GLOBAL -->
            <div class="flex items-center justify-end gap-4 border-b border-[#26352d] bg-[#020806] px-4 py-4 md:px-6">

                <!-- NOTIFICACIONES -->
                <button class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#26352d] bg-[#111613] transition hover:bg-[#1a211d]">
                    <i class="bi bi-bell text-lg"></i>
                    <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-[#72f59a]"></span>
                </button>

                <!-- PERFIL -->
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 rounded-xl border border-[#26352d] bg-[#111613] px-3 py-2 transition hover:border-[#72f59a]/40 hover:bg-[#182019]">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#72f59a] font-bold text-black">
                        {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nombre ?? 'U', 0, 1)) }}
                    </div>

                    <div class="hidden sm:block">
                        <p class="text-sm font-medium text-white">
                            {{ Auth::user()->name ?? Auth::user()->nombre ?? 'Usuario' }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- CONTENIDO -->
            <div class="px-3 py-4 md:px-4 lg:px-5">
                <x-flash-messages />
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
