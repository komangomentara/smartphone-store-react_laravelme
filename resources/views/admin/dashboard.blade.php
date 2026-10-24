<x-admin-layout>
    <h2 class="font-semibold text-xl text-gray-800 mb-4">{{ $title }}</h2>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        @foreach ($stat as $label => $val)
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">{{ $label }}</p>
                <p class="text-xl font-bold text-indigo-600">{{ $val }}</p>
            </div>
        @endforeach
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-2">Perlu Restock (stok ≤ 5)</h3>
        @forelse ($restock as $p)
            <div class="flex justify-between border-b py-1 text-sm">
                <span>{{ $p->nama }} <span class="text-gray-400">({{ $p->brand->nama }})</span></span>
                <span class="{{ $p->stok == 0 ? 'text-red-600' : 'text-yellow-600' }}">{{ $p->stok == 0 ? 'Habis' : 'Sisa '.$p->stok }}</span>
            </div>
        @empty
            <p class="text-gray-500">Semua stok aman.</p>
        @endforelse
    </div>
</x-admin-layout>
