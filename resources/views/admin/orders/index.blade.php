<x-admin-layout>
    <h2 class="font-semibold text-xl text-gray-800 mb-4">{{ $title }}</h2>
    @forelse ($orders as $o)
        <div class="bg-white rounded-lg shadow p-4 mb-3 space-y-2">
            <div class="flex flex-wrap justify-between gap-2">
                <div><p class="font-semibold">{{ $o->kode }}</p><p class="text-xs text-gray-500">{{ $o->created_at->format('d M Y H:i') }} • akun: {{ $o->user->email }}</p></div>
                <form method="POST" action="{{ route('admin.orders.update', $o) }}" class="flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="border rounded-lg px-3 py-1 text-sm">
                        @foreach ($statuses as $s)<option @selected($o->status == $s)>{{ $s }}</option>@endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-indigo-600 text-white rounded-lg">Simpan</button>
                </form>
            </div>
            <p class="text-sm"><b>{{ $o->nama }}</b> ({{ $o->telp }}), {{ $o->alamat }}, {{ $o->kota }} {{ $o->kode_pos }}</p>
            <ul class="text-sm text-gray-700">@foreach ($o->items as $i)<li>{{ $i['nama'] }} × {{ $i['qty'] }}</li>@endforeach</ul>
            <p class="text-sm">Pembayaran: <b>{{ strtoupper($o->metode) }}{{ $o->opsi ? ' - '.$o->opsi : '' }}</b> | Total: <b>Rp {{ number_format($o->total, 0, ',', '.') }}</b></p>
        </div>
    @empty
        <p class="bg-white rounded-lg shadow p-4 text-gray-500">Belum ada pesanan.</p>
    @endforelse
    <div class="mt-4">{{ $orders->links() }}</div>
</x-admin-layout>
