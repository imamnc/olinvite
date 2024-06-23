<?php

namespace Database\Seeders\Collections;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* ROLE ADMINISTRATOR */
        $admin = Role::create([
            'name' => 'admin'
        ]);
        $admin->permissions()->attach([
            1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 33, 34, 35, 37
        ]);

        /* ROLE AFFILIATOR */
        $affiliator = Role::create([
            'name' => 'affiliator'
        ]);
        $affiliator->permissions()->attach([
            30, 31, 32, 36
        ]);
    }
}
