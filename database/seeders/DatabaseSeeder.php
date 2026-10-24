<?php
namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // akun admin dan akun pembeli untuk demo
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@smartphonestore.test';
        $admin->password = Hash::make('password');
        $admin->role = 'admin';
        $admin->save();

        $user = new User();
        $user->name = 'Pembeli Demo';
        $user->email = 'user@smartphonestore.test';
        $user->password = Hash::make('password');
        $user->role = 'user';
        $user->save();

        $brands = [];
        foreach (['iPhone', 'Samsung', 'Xiaomi', 'OPPO', 'Vivo', 'Realme'] as $b) {
            $brands[$b] = Brand::create(['nama' => $b])->id;
        }

        $data = [
            ['iPhone', 'iPhone 15', 14999000, 10, 'Flagship', 4.8, 'Chip A16 Bionic, kamera utama 48MP, layar Super Retina XDR 6.1 inci dengan Dynamic Island.'],
            ['iPhone', 'iPhone 16', 16999000, 5, 'Flagship', 4.9, 'Chip A18, Camera Control, dan performa lebih kencang untuk kebutuhan sehari-hari.'],
            ['Samsung', 'Samsung Galaxy S24', 13999000, 8, 'Flagship', 4.7, 'Layar Dynamic AMOLED 2X 120Hz, fitur Galaxy AI, dan kamera 50MP yang tajam.'],
            ['Samsung', 'Samsung Galaxy A55', 6499000, 15, 'Mid-range', 4.5, 'Bodi premium, layar Super AMOLED 6.6 inci, baterai 5000mAh.'],
            ['Xiaomi', 'Xiaomi Redmi Note 13', 3299000, 20, 'Budget', 4.4, 'Kamera 108MP, layar AMOLED 120Hz, harga bersahabat.'],
            ['Xiaomi', 'Xiaomi 14', 11999000, 0, 'Flagship', 4.7, 'Snapdragon 8 Gen 3, lensa Leica, pengisian daya cepat 90W.'],
            ['OPPO', 'OPPO Reno 12', 7999000, 12, 'Mid-range', 4.5, 'Desain tipis, kamera potret unggulan, fitur AI untuk edit foto.'],
            ['Vivo', 'Vivo V30', 6999000, 4, 'Mid-range', 4.4, 'Kamera Aura Light untuk foto malam, layar melengkung, baterai besar.'],
            ['Realme', 'Realme 13 Pro', 5499000, 14, 'Mid-range', 4.3, 'Kamera 50MP sensor Sony, layar AMOLED, performa stabil.'],
        ];
        foreach ($data as [$brand, $nama, $harga, $stok, $kat, $rating, $desk]) {
            Product::create([
                'brand_id' => $brands[$brand], 'nama' => $nama, 'harga' => $harga, 'stok' => $stok,
                'kategori' => $kat, 'rating' => $rating, 'deskripsi' => $desk, 'status' => 'Y',
                // ganti dengan path foto upload sendiri jika perlu
                'foto' => 'https://placehold.co/400x400/e5e7eb/1f2937?text=' . urlencode($nama),
            ]);
        }
    }
}
