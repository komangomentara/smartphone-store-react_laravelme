<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    const ONGKIR = 25000;

    public function create()
    {
        if (Cart::count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }
        $title = 'Checkout';
        $lines = Cart::lines();
        $subtotal = Cart::total();
        $ongkir = self::ONGKIR;
        return view('frontpage.checkout', compact('title', 'lines', 'subtotal', 'ongkir'));
    }

    public function store(Request $request)
    {
        $lines = Cart::lines();
        if ($lines->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $messages = ['required' => 'Kolom :attribute harus diisi', 'required_if' => 'Kolom :attribute harus diisi'];
        $data = $request->validate([
            'nama' => 'required|string',
            'telp' => 'required|string',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'kode_pos' => 'required|string',
            'metode' => 'required|in:card,ewallet,qris,bank',
            'opsi' => 'required_if:metode,ewallet,bank|nullable|in:Dana,GoPay,BCA,Mandiri,BRI',
            'nomor_kartu' => 'required_if:metode,card|nullable|digits:16',
            'nama_kartu' => 'required_if:metode,card|nullable|string',
            'exp' => 'required_if:metode,card|nullable|string',
            'cvv' => 'required_if:metode,card|nullable|digits_between:3,4',
            'no_ewallet' => 'required_if:metode,ewallet|nullable|digits_between:10,14',
        ], $messages);

        // opsi hanya relevan untuk ewallet / bank
        $opsi = in_array($data['metode'], ['ewallet', 'bank']) ? $data['opsi'] : null;
        $subtotal = Cart::total();

        $order = DB::transaction(function () use ($data, $lines, $opsi, $subtotal) {
            // cek stok lalu kurangi
            foreach ($lines as $l) {
                $p = $l['product']->fresh();
                if ($p->stok < $l['qty']) {
                    abort(422, 'Stok ' . $p->nama . ' tidak cukup.');
                }
                $p->decrement('stok', $l['qty']);
            }

            $bankCode = ['BCA' => '014', 'Mandiri' => '008', 'BRI' => '002'];
            $paidNow = in_array($data['metode'], ['card', 'ewallet']);

            return Order::create([
                'user_id' => auth()->id(),
                'kode' => 'ORD-' . strtoupper(Str::random(8)),
                'nama' => $data['nama'],
                'telp' => $data['telp'],
                'alamat' => $data['alamat'],
                'kota' => $data['kota'],
                'kode_pos' => $data['kode_pos'],
                'metode' => $data['metode'],
                'opsi' => $opsi,
                'va_number' => $data['metode'] === 'bank' ? $bankCode[$opsi] . random_int(1000000000, 9999999999) : null,
                // data kartu asli TIDAK disimpan, hanya 4 digit terakhir
                'kartu_akhir' => $data['metode'] === 'card' ? substr($data['nomor_kartu'], -4) : null,
                'subtotal' => $subtotal,
                'ongkir' => self::ONGKIR,
                'total' => $subtotal + self::ONGKIR,
                'status' => $paidNow ? 'Diproses' : 'Menunggu Pembayaran',
                'items' => $lines->map(fn ($l) => [
                    'id' => $l['product']->id,
                    'nama' => $l['product']->nama,
                    'harga' => $l['product']->harga,
                    'qty' => $l['qty'],
                ])->all(),
            ]);
        });

        Cart::clear();
        return redirect()->route('orders.show', $order);
    }

    public function orders()
    {
        $title = 'Pesanan Saya';
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('frontpage.orders', compact('title', 'orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $title = 'Pesanan ' . $order->kode;
        return view('frontpage.order-success', compact('title', 'order'));
    }
}
