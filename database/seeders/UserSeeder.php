<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ID 1 - Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('admin'),
            'phone' => '081111111111',
            'role' => 'admin',
        ]);

        // ID 2 - Admin
        User::create([
            'name' => 'Stefanus Panji',
            'email' => 'stefanuspanji@gmail.com',
            'password' => Hash::make('admin'),
            'phone' => '089999999999',
            'role' => 'admin',
        ]);

        // ID 3 - Kasir
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@laundry.com',
            'password' => Hash::make('kasir'),
            'phone' => '082222222222',
            'role' => 'kasir',
        ]);

        // ID 4 - Kasir
        User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@laundry.com',
            'password' => Hash::make('kasir2'),
            'phone' => '083333333333',
            'role' => 'kasir',
        ]);

        // ID 5 - Pelanggan
        User::create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@laundry.com',
            'password' => Hash::make('pelanggan'),
            'phone' => '084444444444',
            'role' => 'pelanggan',
        ]);

        // ID 6 - Pelanggan
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@laundry.com',
            'password' => Hash::make('budi'),
            'phone' => '085555555555',
            'role' => 'pelanggan',
        ]);

        // ID 7 - Pelanggan
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@laundry.com',
            'password' => Hash::make('siti'),
            'phone' => '086666666666',
            'role' => 'pelanggan',
        ]);

        // ID 8 - Pelanggan
        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@laundry.com',
            'password' => Hash::make('andi'),
            'phone' => '087777777777',
            'role' => 'pelanggan',
        ]);

        // ID 9 - Pelanggan
        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@laundry.com',
            'password' => Hash::make('dewi'),
            'phone' => '088888888888',
            'role' => 'pelanggan',
        ]);
    }
}
