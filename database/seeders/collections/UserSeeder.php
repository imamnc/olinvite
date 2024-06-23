<?php

namespace Database\Seeders\Collections;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Make Administrator
        User::create([
            'name' => 'Administrator',
            'role_id' => 1,
            'email' => 'admin@olinvite.test',
            'password' => Hash::make('12345678'),
            'is_active' => true
        ]);
    }
}
