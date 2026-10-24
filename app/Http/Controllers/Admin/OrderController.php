<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const STATUSES = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];

    public function index()
    {
        $title = 'Pesanan Masuk';
        $orders = Order::with('user')->latest()->paginate(10);
        $statuses = self::STATUSES;
        return view('admin.orders.index', compact('title', 'orders', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:' . implode(',', self::STATUSES)]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
