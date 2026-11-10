<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\LaundryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            PackageSeeder::class,
            SettingSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            PaymentSeeder::class,
            LaundryStatusSeeder::class,
        ]);
    }
}
