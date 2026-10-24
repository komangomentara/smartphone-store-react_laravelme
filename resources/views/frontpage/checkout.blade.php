<x-home-layout :title="$title">
    @php
        $opsiMap = ['ewallet' => ['Dana', 'GoPay'], 'bank' => ['BCA', 'Mandiri', 'BRI']];
    @endphp
    <form method="POST" action="{{ route('checkout.store') }}"
          x-data="{ metode: '{{ old('metode', 'card') }}', opsi: '{{ old('opsi', '') }}', map: @js($opsiMap) }"
          x-effect="if (map[metode] && !map[metode].includes(opsi)) opsi = map[metode][0]"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <section class="bg-white border rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div><input name="nama" value="{{ old('nama', auth()->user()->name) }}" placeholder="Nama penerima" class="w-full border rounded-lg px-3 py-2">@error('nama')<p class="text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div><input name="telp" value="{{ old('telp') }}" placeholder="No. telepon" class="w-full border rounded-lg px-3 py-2">@error('telp')<p class="text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div class="md:col-span-2"><textarea name="alamat" rows="2" placeholder="Alamat lengkap (jalan, no. rumah, RT/RW)" class="w-full border rounded-lg px-3 py-2">{{ old('alamat') }}</textarea>@error('alamat')<p class="text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div><input name="kota" value="{{ old('kota') }}" placeholder="Kota / Kabupaten" class="w-full border rounded-lg px-3 py-2">@error('kota')<p class="text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div><input name="kode_pos" value="{{ old('kode_pos') }}" placeholder="Kode pos" class="w-full border rounded-lg px-3 py-2">@error('kode_pos')<p class="text-xs text-red-700">{{ $message }}</p>@enderror</div>
                </div>
            </section>

            <section class="bg-white border rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Metode Pembayaran</h2>
                <input type="hidden" name="metode" :value="metode">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                    <template x-for="m in [['card','Kartu Kredit / Debit'],['ewallet','E-Wallet'],['qris','QRIS'],['bank','Transfer Bank']]" :key="m[0]">
                        <button type="button" @click="metode = m[0]"
                                :class="metode === m[0] ? 'border-indigo-600 bg-indigo-50 text-indigo-700 font-semibold' : 'hover:bg-gray-50'"
                                class="border rounded-lg px-3 py-3 text-sm" x-text="m[1]"></button>
                    </template>
                </div>

                <div x-show="map[metode]" class="mb-4">
                    <select name="opsi" x-model="opsi" class="border rounded-lg px-3 py-2">
                        <template x-for="o in (map[metode] || [])" :key="o"><option :value="o" x-text="o"></option></template>
                    </select>
                    @error('opsi')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                </div>

                <div x-show="metode === 'card'" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input name="nomor_kartu" value="{{ old('nomor_kartu') }}" maxlength="16" placeholder="Nomor kartu (16 digit)" class="md:col-span-2 border rounded-lg px-3 py-2">
                    <input name="nama_kartu" value="{{ old('nama_kartu') }}" placeholder="Nama di kartu" class="border rounded-lg px-3 py-2">
                    <div class="grid grid-cols-2 gap-3">
                        <input name="exp" value="{{ old('exp') }}" placeholder="MM/YY" maxlength="5" class="border rounded-lg px-3 py-2">
                        <input name="cvv" type="password" maxlength="4" placeholder="CVV" class="border rounded-lg px-3 py-2">
                    </div>
                    <p class="text-xs text-gray-500 md:col-span-2">Prototype: tidak ada pembayaran asli. Hanya 4 digit terakhir kartu yang disimpan. Jangan isi data kartu sungguhan.</p>
                    @foreach (['nomor_kartu','nama_kartu','exp','cvv'] as $f)@error($f)<p class="text-xs text-red-700">{{ $message }}</p>@enderror @endforeach
                </div>
                <div x-show="metode === 'ewallet'">
                    <input name="no_ewallet" value="{{ old('no_ewallet') }}" placeholder="Nomor HP akun e-wallet" class="w-full border rounded-lg px-3 py-2">
                    @error('no_ewallet')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                </div>
                <p x-show="metode === 'qris'" class="text-sm text-gray-600">Kode QRIS akan muncul setelah pesanan dibuat.</p>
                <p x-show="metode === 'bank'" class="text-sm text-gray-600">Nomor Virtual Account akan muncul setelah pesanan dibuat.</p>
            </section>
        </div>

        <aside class="bg-white border rounded-xl shadow-sm p-6 h-fit space-y-3">
            <h2 class="text-xl font-semibold">Ringkasan Pesanan</h2>
            <ul class="text-sm space-y-1">
                @foreach ($lines as $l)
                    <li class="flex justify-between gap-2"><span>{{ $l['product']->nama }} × {{ $l['qty'] }}</span><span>Rp {{ number_format($l['subtotal'], 0, ',', '.') }}</span></li>
                @endforeach
            </ul>
            <hr>
            <div class="flex justify-between text-sm"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
            <div class="flex justify-between text-sm"><span>Ongkir</span><span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span></div>
            <div class="flex justify-between font-bold text-lg text-indigo-600"><span>Total</span><span>Rp {{ number_format($subtotal + $ongkir, 0, ',', '.') }}</span></div>
            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Buat Pesanan</button>
        </aside>
    </form>
</x-home-layout>
