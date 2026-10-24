<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Smartphone Store') }}</title>
    {{-- Tailwind via CDN (seperti catatan modul jika instalasi vite bermasalah) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .bg-sidebar { background: #3d68ff; }
        .nav-item:hover, .active-nav-link { background: #1947ee; }
    </style>
</head>
<body class="bg-gray-100 flex">
    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <a href="{{ route('admin.products.create') }}" class="block text-center w-full bg-white text-blue-600 font-semibold py-2 mt-5 rounded-lg shadow-lg hover:bg-gray-200">+ Produk Baru</a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-4 pl-6 nav-item {{ request()->routeIs('admin.dashboard') ? 'active-nav-link' : 'opacity-75' }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center py-4 pl-6 nav-item {{ request()->routeIs('admin.products.*') ? 'active-nav-link' : 'opacity-75' }}">Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center py-4 pl-6 nav-item {{ request()->routeIs('admin.orders.*') ? 'active-nav-link' : 'opacity-75' }}">Pesanan</a>
            <a href="{{ route('home') }}" class="flex items-center py-4 pl-6 nav-item opacity-75">← Lihat Toko</a>
        </nav>
    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <header class="w-full items-center bg-white py-3 px-6 hidden sm:flex justify-end gap-4">
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-600 hover:underline">Logout</button>
            </form>
        </header>
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold uppercase">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-2xl focus:outline-none">☰</button>
            </div>
            <nav :class="isOpen ? 'flex' : 'hidden'" class="flex-col pt-4 text-white font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="py-2 pl-4 nav-item">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="py-2 pl-4 nav-item">Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="py-2 pl-4 nav-item">Pesanan</a>
                <a href="{{ route('home') }}" class="py-2 pl-4 nav-item">Lihat Toko</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="py-2 pl-4 text-left w-full nav-item">Logout</button></form>
            </nav>
        </header>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2 text-sm">{{ session('success') }}</div>
                @endif
                {{ $slot }}
            </main>
            <footer class="w-full bg-white text-right p-4 text-sm text-gray-500">© 2026 Smartphone Store Admin</footer>
        </div>
    </div>
</body>
</html>
