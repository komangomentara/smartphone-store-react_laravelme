<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id','nama','harga','stok','kategori','rating','deskripsi','foto','status'];

    // setiap produk milik satu brand (belongsTo)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // URL gambar: bisa link luar (http...) atau file upload di storage
    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return 'https://placehold.co/400x400/e5e7eb/1f2937?text=' . urlencode($this->nama);
        }
        return str_starts_with($this->foto, 'http') ? $this->foto : asset('storage/' . $this->foto);
    }
}
