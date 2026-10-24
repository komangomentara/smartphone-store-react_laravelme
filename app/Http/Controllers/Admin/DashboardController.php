<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';
        $stat = [
            'Total Produk' => Product::count(),
            'Total Stok' => Product::sum('stok'),
            'Stok Habis' => Product::where('stok', 0)->count(),
            'Total Pesanan' => Order::count(),
            'Pendapatan' => 'Rp ' . number_format(Order::where('status', '!=', 'Dibatalkan')->sum('total'), 0, ',', '.'),
        ];
        $restock = Product::with('brand')->where('stok', '<=', 5)->orderBy('stok')->get();
        return view('admin.dashboard', compact('title', 'stat', 'restock'));
    }
}
