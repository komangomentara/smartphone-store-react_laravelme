<x-home-layout :title="$title">
    <h1 class="text-2xl font-bold mb-4">Pesanan Saya</h1>
    @forelse ($orders as $o)
        <a href="{{ route('orders.show', $o) }}" class="block bg-white border rounded-lg p-4 mb-3 hover:shadow">
            <div class="flex justify-between"><b>{{ $o->kode }}</b><span class="text-sm">{{ $o->status }}</span></div>
            <p class="text-sm text-gray-500">{{ $o->created_at->format('d M Y H:i') }} • Rp {{ number_format($o->total, 0, ',', '.') }}</p>
        </a>
    @empty
        <p class="text-gray-500">Belum ada pesanan.</p>
    @endforelse
</x-home-layout>
