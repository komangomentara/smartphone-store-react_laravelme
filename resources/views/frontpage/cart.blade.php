<x-home-layout :title="$title">
    <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

    @if ($lines->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-600 mb-3">Keranjang masih kosong.</p>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">Belanja sekarang</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($lines as $l)
                @php $p = $l['product']; @endphp
                <div class="flex flex-wrap items-center justify-between gap-4 bg-white border p-4 rounded-lg shadow-sm">
                    <div class="flex items-center gap-4">
                        <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" class="w-16 h-16 object-contain">
                        <div>
                            <h2 class="font-semibold">{{ $p->nama }}</h2>
                            <p class="text-gray-600">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('cart.update', $p) }}" class="flex gap-2">@csrf @method('PATCH')
                            <input type="number" name="qty" value="{{ $l['qty'] }}" min="1" max="{{ $p->stok }}" class="w-20 border rounded text-center">
                            <button class="px-3 py-1 border rounded hover:bg-gray-100">Ubah</button>
                        </form>
                        <p class="w-32 text-right font-semibold">Rp {{ number_format($l['subtotal'], 0, ',', '.') }}</p>
                        <form method="POST" action="{{ route('cart.remove', $p) }}">@csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 bg-white border rounded-lg p-4 shadow flex flex-wrap justify-between items-center gap-3">
            <p class="text-xl font-bold text-indigo-600">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
            <a href="{{ route('checkout.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Lanjut ke Checkout</a>
        </div>
        @guest
            <p class="mt-2 text-sm text-gray-500">Kamu perlu login saat checkout.</p>
        @endguest
    @endif
</x-home-layout>
