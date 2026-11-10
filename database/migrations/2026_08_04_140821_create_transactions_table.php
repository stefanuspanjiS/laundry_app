<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('cashier_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('total_berat',8,2);

            $table->decimal('subtotal',12,2);

            $table->decimal('diskon',12,2)->default(0);

            $table->decimal('total_bayar',12,2);

            $table->enum('status_pembayaran',[
                'belum_bayar',
                'dibayar',
                'dibatalkan'
            ])->default('belum_bayar');

            $table->enum('status_laundry',[
                'menunggu',
                'dicuci',
                'dikeringkan',
                'disetrika',
                'siap_diambil',
                'selesai'
            ])->default('menunggu');

            $table->date('tanggal_masuk');

            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
