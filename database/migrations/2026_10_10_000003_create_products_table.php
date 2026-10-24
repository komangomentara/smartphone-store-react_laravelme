<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // foreign key ke tabel brands (relasi one to many)
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('nama');
            $table->unsignedInteger('harga');
            $table->unsignedInteger('stok')->default(0);
            $table->string('kategori');
            $table->decimal('rating', 2, 1)->default(4.0);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->char('status', 1)->default('Y'); // Y = tampil, N = disembunyikan
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
