<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,        // 1. roles: admin, member
            CategorySeeder::class,    // 2. categories: pemasukan + pengeluaran + kostum cosplay
            UserSeeder::class,        // 3. users + profiles (admin + 10 member)
            CostumSeeder::class,      // 4. kostum cosplay Jepang
            // NarutoOrderSeeder::class, // 5. transaksi naruto (confirmated + pending + cart + rating prompt)
            // MaintenanceSeeder::class, // 6. maintenance kostum pasca pengembalian
            // FinanceSeeder::class,     // 7. finance: pemasukan dari order confirmated + pengeluaran operasional
        ]);
    }
}
