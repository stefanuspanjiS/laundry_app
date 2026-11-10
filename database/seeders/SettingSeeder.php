<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'nama_laundry' => "SAM'S Laundry Kendal",
            'owner' => 'Owner Laundry',
            'email' => 'admin@samslaundry.com',
            'phone' => '081234567890',
            'alamat' => 'Kendal, Jawa Tengah',
            'logo' => null,
        ]);
    }
}
