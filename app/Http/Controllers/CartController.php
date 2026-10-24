<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Keranjang';
        $lines = Cart::lines();
        $total = Cart::total();
        return view('frontpage.cart', compact('title', 'lines', 'total'));
    }

    public function add(Product $product)
    {
        $cart = Cart::raw();
        $qty = ($cart[$product->id] ?? 0) + 1;
        if ($qty > $product->stok) {
            return back()->with('error', 'Stok ' . $product->nama . ' tidak cukup.');
        }
        $cart[$product->id] = $qty;
        session(['cart' => $cart]);
        return back()->with('success', $product->nama . ' masuk keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $qty = max(1, min((int) $request->qty, $product->stok));
        $cart = Cart::raw();
        if (isset($cart[$product->id])) {
            $cart[$product->id] = $qty;
            session(['cart' => $cart]);
        }
        return back();
    }

    public function remove(Product $product)
    {
        $cart = Cart::raw();
        unset($cart[$product->id]);
        session(['cart' => $cart]);
        return back();
    }
}
