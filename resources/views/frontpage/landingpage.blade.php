<x-home-layout :title="$title">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl p-8 mb-6">
        <h1 class="text-3xl font-bold">SMARTPHONE STORE</h1>
        <p class="mt-2">Temukan smartphone impianmu :)</p>
    </div>

    {{-- PENCARIAN & FILTER: form method GET --}}
    <form method="GET" action="{{ route('home') }}" class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-6">
        <input type="text" name="s" value="{{ request('s') }}" placeholder="Ketik nama HP..." class="md:col-span-2 px-4 py-2 border rounded-lg">
        <select name="brand_id" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Brand</option>
            @foreach ($brands as $b)
                <option value="{{ $b->id }}" @selected(request('brand_id') == $b->id)>{{ $b->nama }}</option>
            @endforeach
        </select>
        <select name="kategori" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Kategori</option>
            @foreach (['Flagship', 'Mid-range', 'Budget'] as $k)
                <option value="{{ $k }}" @selected(request('kategori') == $k)>{{ $k }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <select name="sort" class="px-4 py-2 border rounded-lg flex-1">
                <option value="">Urutkan</option>
                <option value="termurah" @selected(request('sort') == 'termurah')>Termurah</option>
                <option value="termahal" @selected(request('sort') == 'termahal')>Termahal</option>
            </select>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Cari</button>
        </div>
    </form>

    {{-- Conditional rendering: ada produk / tidak --}}
    @if ($products->isEmpty())
        <p class="text-center text-gray-500 py-10">Produk tidak ditemukan.</p>
    @else
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $p)
                <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg p-4 flex flex-col">
                    <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" class="w-full h-48 object-contain mb-3">
                    <p class="text-sm text-gray-500">{{ $p->brand->nama }} • {{ $p->kategori }}</p>
                    <h2 class="font-semibold">{{ $p->nama }}</h2>
                    <p class="text-yellow-500 text-sm">★ {{ $p->rating }}</p>
                    <p class="text-indigo-600 font-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                    @if ($p->stok == 0)
                        <span class="mt-1 text-xs bg-red-100 text-red-600 px-2 py-1 rounded w-fit">Stok habis</span>
                    @elseif ($p->stok <= 5)
                        <span class="mt-1 text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded w-fit">Sisa {{ $p->stok }}</span>
                    @else
                        <span class="mt-1 text-xs bg-green-100 text-green-700 px-2 py-1 rounded w-fit">Tersedia</span>
                    @endif
                    <div class="mt-auto pt-4 flex gap-2">
                        <a href="{{ route('product.show', $p) }}" class="flex-1 text-center border rounded-lg py-2 text-indigo-600 hover:bg-indigo-50">Detail</a>
                        <form method="POST" action="{{ route('cart.add', $p) }}" class="flex-1">@csrf
                            <button @disabled($p->stok == 0) class="w-full rounded-lg py-2 text-white {{ $p->stok == 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                                {{ $p->stok == 0 ? 'Habis' : '+ Keranjang' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
</x-home-layout>
