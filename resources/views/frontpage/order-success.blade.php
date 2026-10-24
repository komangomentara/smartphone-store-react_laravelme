<x-home-layout :title="$title">
    <div class="max-w-xl mx-auto bg-white border rounded-xl shadow-sm p-6 space-y-4">
        <div class="text-center">
            <p class="text-5xl">✅</p>
            <h1 class="text-2xl font-bold mt-2">Pesanan Berhasil Dibuat</h1>
            <p class="text-gray-500">Nomor pesanan: <b>{{ $order->kode }}</b></p>
        </div>
        <div class="text-sm border rounded-lg p-4 space-y-1 bg-gray-50">
            <p><b>Dikirim ke:</b> {{ $order->nama }} ({{ $order->telp }})</p>
            <p>{{ $order->alamat }}, {{ $order->kota }} {{ $order->kode_pos }}</p>
            <p><b>Pembayaran:</b>
                @if ($order->metode === 'card') Kartu Kredit/Debit (•••• {{ $order->kartu_akhir }})
                @elseif ($order->metode === 'qris') QRIS
                @else {{ $order->metode === 'bank' ? 'Transfer Bank' : 'E-Wallet' }} - {{ $order->opsi }}
                @endif
            </p>
            <p><b>Status:</b> {{ $order->status }}</p>
            <p><b>Total:</b> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </div>

        @if ($order->va_number)
            <div class="border rounded-lg p-4 text-sm">
                <p>Transfer ke Virtual Account {{ $order->opsi }}:</p>
                <p class="text-xl font-bold tracking-wider">{{ $order->va_number }}</p>
                <p class="text-gray-500">(Nomor simulasi, bukan rekening asli)</p>
            </div>
        @endif
        @if ($order->metode === 'qris')
            <div class="flex flex-col items-center gap-2">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($order->kode) }}" alt="QR" class="border p-2">
                <p class="text-sm text-gray-500">QR simulasi untuk membayar Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
        @endif

        <a href="{{ route('home') }}" class="block text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Kembali Belanja</a>
    </div>
</x-home-layout>
