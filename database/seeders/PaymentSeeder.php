<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::insert([
            [
                'transaction_id' => 1,
                'metode' => 'cash',
                'midtrans_order_id' => null,
                'midtrans_transaction_id' => null,
                'jumlah' => 27000,
                'status' => 'success',
                'paid_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 2,
                'metode' => 'midtrans',
                'midtrans_order_id' => 'ORDER-002',
                'midtrans_transaction_id' => 'MID-002',
                'jumlah' => 40000,
                'status' => 'success',
                'paid_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 3,
                'metode' => 'cash',
                'midtrans_order_id' => null,
                'midtrans_transaction_id' => null,
                'jumlah' => 18000,
                'status' => 'pending',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 4,
                'metode' => 'cash',
                'midtrans_order_id' => null,
                'midtrans_transaction_id' => null,
                'jumlah' => 36000,
                'status' => 'success',
                'paid_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 5,
                'metode' => 'midtrans',
                'midtrans_order_id' => 'ORDER-005',
                'midtrans_transaction_id' => 'MID-005',
                'jumlah' => 50000,
                'status' => 'pending',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
