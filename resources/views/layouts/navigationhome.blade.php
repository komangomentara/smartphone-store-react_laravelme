<nav x-data="{ open: false }" class="bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
        <a href="{{ route('home') }}" class="font-bold text-xl">📱 SMARTPHONE <span class="text-indigo-400">STORE</span></a>

        <div class="hidden sm:flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-slate-300 hover:text-white">Home</a>
            <a href="{{ route('cart.index') }}" class="text-slate-300 hover:text-white">
                Keranjang
                @if (\App\Support\Cart::count() > 0)
                    <span class="ml-1 bg-indigo-500 text-xs px-2 py-0.5 rounded-full">{{ \App\Support\Cart::count() }}</span>
                @endif
            </a>
            @auth
                <a href="{{ route('orders.index') }}" class="text-slate-300 hover:text-white">Pesanan Saya</a>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-yellow-300 hover:text-yellow-100">Admin</a>
                @endif
                <span class="text-slate-400">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="text-red-300 hover:text-red-100">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-300 hover:text-white">Login</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 px-3 py-1 rounded hover:bg-indigo-700">Register</a>
            @endauth
        </div>

        <button @click="open = !open" class="sm:hidden text-2xl">☰</button>
    </div>

    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2 text-sm">
        <a href="{{ route('home') }}" class="block">Home</a>
        <a href="{{ route('cart.index') }}" class="block">Keranjang ({{ \App\Support\Cart::count() }})</a>
        @auth
            <a href="{{ route('orders.index') }}" class="block">Pesanan Saya</a>
            @if (auth()->user()->role === 'admin')<a href="{{ route('admin.dashboard') }}" class="block text-yellow-300">Admin</a>@endif
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-red-300">Logout</button></form>
        @else
            <a href="{{ route('login') }}" class="block">Login</a>
            <a href="{{ route('register') }}" class="block">Register</a>
        @endauth
    </div>
</nav>
