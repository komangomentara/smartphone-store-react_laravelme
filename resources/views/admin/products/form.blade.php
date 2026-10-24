<x-admin-layout>
    <h2 class="font-semibold text-xl text-gray-800 mb-4">{{ $title }}</h2>
    <div class="shadow px-6 py-4 bg-white rounded">
        <form enctype="multipart/form-data"
              action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST">
            @csrf
            @if (isset($product)) @method('PUT') @endif

            <div class="grid grid-cols-6 gap-6 py-4">
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $product->nama ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    @error('nama')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                    <select name="brand_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md sm:text-sm">
                        <option value="">Pilih Brand</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id ?? '') == $b->id)>{{ $b->nama }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md sm:text-sm">
                        @foreach (['Flagship', 'Mid-range', 'Budget'] as $k)
                            <option @selected(old('kategori', $product->kategori ?? '') == $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $product->harga ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    @error('harga')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $product->stok ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    @error('stok')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <input type="number" step="0.1" name="rating" value="{{ old('rating', $product->rating ?? 4) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    @error('rating')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Foto</label>
                    <input type="file" name="foto" class="mt-1 block w-full border-gray-300 rounded-md sm:text-sm">
                    @error('foto')<div class="text-xs text-red-800">{{ $message }}</div>@enderror
                    @isset($product)<img src="{{ $product->foto_url }}" class="h-16 mt-2" alt="">@endisset
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <label class="mr-4"><input type="radio" name="status" value="Y" @checked(old('status', $product->status ?? 'Y') == 'Y')> Tampil</label>
                    <label><input type="radio" name="status" value="N" @checked(old('status', $product->status ?? 'Y') == 'N')> Sembunyikan</label>
                </div>
                <div class="col-span-6">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="py-3 text-right">
                <a href="{{ route('admin.products.index') }}" class="mr-3 text-sm text-gray-600">Batal</a>
                <button type="submit" class="inline-flex justify-center w-24 py-2 px-4 text-sm font-medium rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Save</button>
            </div>
        </form>
    </div>
</x-admin-layout>
