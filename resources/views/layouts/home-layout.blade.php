<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Smartphone Store - toko HP online: iPhone, Samsung, Xiaomi, OPPO, Vivo, Realme">
    <title>{{ $title ?? config('app.name', 'Smartphone Store') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen flex flex-col">
    @include('layouts.navigationhome')

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2 text-sm">{{ session('error') }}</div>
        @endif
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 text-sm">© 2026 Smartphone Store | Laravel + Breeze + Tailwind</footer>
</div>
</body>
</html>
