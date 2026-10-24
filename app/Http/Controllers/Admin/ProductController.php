<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Resource controller CRUD (sesuai modul: php artisan make:controller ... -r)
class ProductController extends Controller
{
    private function rules(bool $isUpdate = false): array
    {
        return [
            'nama' => 'required|string|max:100',
            'brand_id' => 'required|exists:brands,id',
            'kategori' => 'required|in:Flagship,Mid-range,Budget',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'status' => 'required|in:Y,N',
        ];
    }

    private $messages = [
        'required' => 'Kolom :attribute harus lengkap',
        'numeric' => 'Kolom :attribute harus angka.',
        'mimes' => 'Perhatikan format file (png/jpg/webp)',
        'max' => 'Ukuran/isi kolom :attribute melebihi batas',
    ];

    // READ: daftar + search + filter + pagination
    public function index(Request $request)
    {
        $title = 'Kelola Produk';
        $products = Product::with('brand');
        if ($request->filled('s')) {
            $products->where('nama', 'like', '%' . $request->s . '%');
        }
        if ($request->filled('brand_id')) {
            $products->where('brand_id', $request->brand_id);
        }
        $products = $products->latest()->paginate(5)->withQueryString();
        $brands = Brand::orderBy('nama')->get();
        return view('admin.products.index', compact('title', 'products', 'brands'));
    }

    public function create()
    {
        $title = 'Tambah Produk';
        $brands = Brand::orderBy('nama')->get();
        return view('admin.products.form', compact('title', 'brands'));
    }

    // CREATE
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $title = 'Edit ' . $product->nama;
        $brands = Brand::orderBy('nama')->get();
        return view('admin.products.form', compact('title', 'brands', 'product'));
    }

    // UPDATE
    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules(true), $this->messages);
        if ($request->hasFile('foto')) {
            $this->deleteFile($product);
            $data['foto'] = $request->file('foto')->store('uploads/products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diubah.');
    }

    // DELETE
    public function destroy(Product $product)
    {
        $this->deleteFile($product);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }

    private function deleteFile(Product $product): void
    {
        if ($product->foto && !str_starts_with($product->foto, 'http')) {
            Storage::disk('public')->delete($product->foto);
        }
    }
}
