<?php

namespace Database\Seeders;

use App\Models\LaundryStatus;
use Illuminate\Database\Seeder;

class LaundryStatusSeeder extends Seeder
{
    public function run(): void
    {
        LaundryStatus::insert([
            [
                'transaction_id' => 1,
                'status' => 'selesai',
                'keterangan' => 'Laundry telah selesai dan diambil.',
                'updated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 2,
                'status' => 'dicuci',
                'keterangan' => 'Sedang dalam proses pencucian.',
                'updated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 3,
                'status' => 'menunggu',
                'keterangan' => 'Menunggu antrian pencucian.',
                'updated_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 4,
                'status' => 'disetrika',
                'keterangan' => 'Sedang proses penyetrikaan.',
                'updated_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 5,
                'status' => 'siap_diambil',
                'keterangan' => 'Laundry siap diambil pelanggan.',
                'updated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
