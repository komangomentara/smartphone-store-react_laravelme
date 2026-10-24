<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Landing page + search + filter + sort + pagination (sesuai BAB Filter and Search)
    public function index(Request $request)
    {
        $title = 'Smartphone Store';
        $products = Product::with('brand')->where('status', 'Y');

        if ($request->filled('s')) {
            $products->where('nama', 'like', '%' . $request->s . '%');
        }
        if ($request->filled('brand_id')) {
            $products->where('brand_id', $request->brand_id);
        }
        if ($request->filled('kategori')) {
            $products->where('kategori', $request->kategori);
        }
        if ($request->sort === 'termurah') $products->orderBy('harga');
        elseif ($request->sort === 'termahal') $products->orderByDesc('harga');
        else $products->orderBy('id');

        $products = $products->paginate(8)->withQueryString();
        $brands = Brand::orderBy('nama')->get();

        return view('frontpage.landingpage', compact('title', 'products', 'brands'));
    }

    public function show(Product $product)
    {
        abort_if($product->status !== 'Y', 404);
        $title = $product->nama;
        return view('frontpage.detail', compact('title', 'product'));
    }
}
