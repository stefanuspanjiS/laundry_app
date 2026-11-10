<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    public function run(): void
    {
        TransactionDetail::insert([
            [
                'transaction_id' => 1,
                'package_id' => 2,
                'berat' => 3,
                'harga' => 9000,
                'subtotal' => 27000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 2,
                'package_id' => 2,
                'berat' => 5,
                'harga' => 9000,
                'subtotal' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 3,
                'package_id' => 1,
                'berat' => 2,
                'harga' => 9000,
                'subtotal' => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 4,
                'package_id' => 2,
                'berat' => 4,
                'harga' => 9000,
                'subtotal' => 36000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 5,
                'package_id' => 4,
                'berat' => 6,
                'harga' => 9000,
                'subtotal' => 54000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
