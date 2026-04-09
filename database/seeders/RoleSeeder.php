<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'member'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
