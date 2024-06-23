<?php

namespace Database\Seeders\Collections;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Permission Groups'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Permissions'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Roles'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Users'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Bank Channels'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Invitation Types'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Payment Channels'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Themes'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Music'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Quotes'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Invitations'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Invoices'
        ]);
        // User Permission Group
        PermissionGroup::create([
            'name' => 'Saldo'
        ]);
    }
}
