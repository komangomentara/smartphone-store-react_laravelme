<x-admin-layout>
    <h2 class="font-semibold text-xl text-gray-800 mb-4">{{ $title }}</h2>
    <div class="shadow px-6 py-4 bg-white rounded">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-2">
            <div>
                <a href="{{ route('admin.products.create') }}">
                    <button class="px-4 py-1 text-sm rounded text-purple-600 font-semibold border border-purple-200 hover:text-white hover:bg-purple-600">Tambah</button>
                </a>
            </div>
            <form method="GET" class="flex md:justify-end gap-2">
                <input type="text" name="s" value="{{ request('s') }}" placeholder="Cari nama..." class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                <select name="brand_id" class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                    <option value="">Semua Brand</option>
                    @foreach ($brands as $b)<option value="{{ $b->id }}" @selected(request('brand_id') == $b->id)>{{ $b->nama }}</option>@endforeach
                </select>
                <button class="px-4 py-1 border border-gray-300 rounded-md text-blue-600 hover:text-white hover:bg-blue-600">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @foreach (['Produk', 'Brand / Kategori', 'Harga', 'Stok', 'Status'] as $h)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $h }}</th>
                    @endforeach
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($products as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $item->foto_url }}" alt="">
                                <div class="ml-4 text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm"><div>{{ $item->brand->nama }}</div><div class="text-gray-500">{{ $item->kategori }}</div></td>
                        <td class="px-6 py-4 text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm {{ $item->stok == 0 ? 'text-red-600' : '' }}">{{ $item->stok }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->status == 'Y' ? 'Tampil' : 'Disembunyikan' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.products.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <a href="{{ route('admin.products.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <button class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Anda Yakin ?')" type="submit">Del</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-6 text-center text-gray-500">Data tidak ditemukan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="m-4">{{ $products->links() }}</div>
    </div>
</x-admin-layout>
