<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Invitation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InvitationTypeSeeder::class,
            PermissionGroupSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // Invitation
        $invitation = Invitation::create([
            'code' => 'invitation1',
            'password' => Hash::make('12345678'),
            'password_default' => '12345678',
        ]);
        // Invoice
        $invitation->invoice()->create([
            'code' => strtoupper(uniqid('INV-')),
        ]);
        // Wedding Data
        $invitation->wedding_data()->create([]);
    }
}
