<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::insert([

            [
                'nama_paket' => 'Cuci Kering',
                'harga_per_kg' => 7000,
                'estimasi_hari' => 2,
                'deskripsi' => 'Laundry cuci kering',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_paket' => 'Cuci + Setrika',
                'harga_per_kg' => 9000,
                'estimasi_hari' => 3,
                'deskripsi' => 'Laundry cuci dan setrika',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_paket' => 'Setrika',
                'harga_per_kg' => 5000,
                'estimasi_hari' => 1,
                'deskripsi' => 'Jasa setrika',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_paket' => 'Express',
                'harga_per_kg' => 15000,
                'estimasi_hari' => 1,
                'deskripsi' => 'Laundry express',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
