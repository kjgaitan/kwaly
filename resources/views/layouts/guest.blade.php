<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KWALY</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#020806] text-white antialiased">

    <x-flash-messages />

    {{ $slot }}

</body>

</html>
