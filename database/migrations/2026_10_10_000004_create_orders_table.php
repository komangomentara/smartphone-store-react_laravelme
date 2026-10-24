<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('telp');
            $table->string('alamat');
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('metode');            // card, ewallet, qris, bank
            $table->string('opsi')->nullable();  // Dana/GoPay atau BCA/Mandiri/BRI
            $table->string('va_number')->nullable();
            $table->string('kartu_akhir', 4)->nullable(); // hanya 4 digit terakhir
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('ongkir');
            $table->unsignedInteger('total');
            $table->string('status')->default('Menunggu Pembayaran');
            $table->json('items');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
