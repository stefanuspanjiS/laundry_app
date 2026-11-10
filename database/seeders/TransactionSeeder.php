<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::insert([
            [
                'invoice' => 'INV-20260804-001',
                'customer_id' => 4,
                'cashier_id' => 2,
                'total_berat' => 3,
                'subtotal' => 27000,
                'diskon' => 0,
                'total_bayar' => 27000,
                'status_pembayaran' => 'dibayar',
                'status_laundry' => 'selesai',
                'tanggal_masuk' => now()->subDays(3),
                'tanggal_selesai' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'invoice' => 'INV-20260804-002',
                'customer_id' => 5,
                'cashier_id' => 2,
                'total_berat' => 5,
                'subtotal' => 45000,
                'diskon' => 5000,
                'total_bayar' => 40000,
                'status_pembayaran' => 'dibayar',
                'status_laundry' => 'dicuci',
                'tanggal_masuk' => now()->subDays(1),
                'tanggal_selesai' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'invoice' => 'INV-20260804-003',
                'customer_id' => 6,
                'cashier_id' => 3,
                'total_berat' => 2,
                'subtotal' => 18000,
                'diskon' => 0,
                'total_bayar' => 18000,
                'status_pembayaran' => 'belum_bayar',
                'status_laundry' => 'menunggu',
                'tanggal_masuk' => now(),
                'tanggal_selesai' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'invoice' => 'INV-20260804-004',
                'customer_id' => 7,
                'cashier_id' => 3,
                'total_berat' => 4,
                'subtotal' => 36000,
                'diskon' => 0,
                'total_bayar' => 36000,
                'status_pembayaran' => 'dibayar',
                'status_laundry' => 'disetrika',
                'tanggal_masuk' => now()->subDays(2),
                'tanggal_selesai' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'invoice' => 'INV-20260804-005',
                'customer_id' => 8,
                'cashier_id' => 2,
                'total_berat' => 6,
                'subtotal' => 54000,
                'diskon' => 4000,
                'total_bayar' => 50000,
                'status_pembayaran' => 'belum_bayar',
                'status_laundry' => 'siap_diambil',
                'tanggal_masuk' => now()->subDays(4),
                'tanggal_selesai' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
