<x-home-layout :title="$title">
    <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">← Kembali</a>
    <div class="mt-4 bg-white border rounded-xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <img src="{{ $product->foto_url }}" alt="{{ $product->nama }}" class="w-full rounded-lg object-contain max-h-96">
        <div>
            <p class="text-sm text-gray-500">{{ $product->brand->nama }} • {{ $product->kategori }}</p>
            <h1 class="text-3xl font-bold">{{ $product->nama }}</h1>
            <p class="text-yellow-500 mt-1">★ {{ $product->rating }}</p>
            <p class="text-2xl text-indigo-600 font-bold mt-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
            <p class="mt-3 text-gray-700">{{ $product->deskripsi }}</p>

            @if ($product->stok > 0)
                <p class="mt-3 text-green-600">Stok: {{ $product->stok }}</p>
                <form method="POST" action="{{ route('cart.add', $product) }}">@csrf
                    <button class="mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Tambah ke Keranjang</button>
                </form>
            @else
                <p class="mt-3 text-red-600 font-semibold">Stok habis</p>
                <button disabled class="mt-4 px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">Tidak tersedia</button>
            @endif
        </div>
    </div>
</x-home-layout>
