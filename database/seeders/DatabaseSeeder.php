<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Collections\BankChannelSeeder;
use Database\Seeders\Collections\FormTypeSeeder;
use Database\Seeders\Collections\InvitationSeeder;
use Database\Seeders\Collections\InvitationTypeSeeder;
use Database\Seeders\Collections\MusicSeeder;
use Database\Seeders\Collections\PermissionGroupSeeder;
use Database\Seeders\Collections\PermissionSeeder;
use Database\Seeders\Collections\RoleSeeder;
use Database\Seeders\Collections\ThemeSeeder;
use Database\Seeders\Collections\UserSeeder;
use Illuminate\Database\Seeder;

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
            FormTypeSeeder::class,
            ThemeSeeder::class,
            BankChannelSeeder::class,
            MusicSeeder::class,
            InvitationSeeder::class,
            PermissionGroupSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
