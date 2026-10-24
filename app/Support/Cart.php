<?php
namespace App\Support;

use App\Models\Product;

// Keranjang disimpan di session: [product_id => qty]
class Cart
{
    public static function raw(): array { return session('cart', []); }

    public static function count(): int { return array_sum(self::raw()); }

    public static function clear(): void { session()->forget('cart'); }

    public static function lines()
    {
        $raw = self::raw();
        $products = Product::whereIn('id', array_keys($raw))->get()->keyBy('id');
        return collect($raw)->map(function ($qty, $id) use ($products) {
            $p = $products[$id] ?? null;
            return $p ? ['product' => $p, 'qty' => $qty, 'subtotal' => $p->harga * $qty] : null;
        })->filter()->values();
    }

    public static function total(): int { return (int) self::lines()->sum('subtotal'); }
}
