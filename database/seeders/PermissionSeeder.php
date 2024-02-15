<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* ===========================================================
         PERMISSIONS GROUPS
        ============================================================*/
        // Permission for insert permission groups (ADMIN)
        Permission::create([
            'permission_group_id' => 1,
            'name' => 'insert permission groups'
        ]);
        // Permission for edit permission groups (ADMIN)
        Permission::create([
            'permission_group_id' => 1,
            'name' => 'edit permission groups'
        ]);
        // Permission for delete permission groups (ADMIN)
        Permission::create([
            'permission_group_id' => 1,
            'name' => 'delete permission groups'
        ]);
        // Permission for activation permission groups (ADMIN)
        Permission::create([
            'permission_group_id' => 1,
            'name' => 'activation permission groups'
        ]);
        // Permission for check/validate permission groups (ADMIN)
        Permission::create([
            'permission_group_id' => 1,
            'name' => 'check permission groups'
        ]);

        /* ===========================================================
         PERMISSIONS
        ============================================================*/
        // Permission for insert permission (ADMIN)
        Permission::create([
            'permission_group_id' => 2,
            'name' => 'insert permission'
        ]);
        // Permission for edit permission (ADMIN)
        Permission::create([
            'permission_group_id' => 2,
            'name' => 'edit permission'
        ]);
        // Permission for delete permission (ADMIN)
        Permission::create([
            'permission_group_id' => 2,
            'name' => 'delete permission'
        ]);
        // Permission for activation permission (ADMIN)
        Permission::create([
            'permission_group_id' => 2,
            'name' => 'activation permission'
        ]);
        // Permission for check/validate permission (ADMIN)
        Permission::create([
            'permission_group_id' => 2,
            'name' => 'check permission'
        ]);

        /* ===========================================================
         ROLES
        ============================================================*/
        // Permission for insert roles (ADMIN)
        Permission::create([
            'permission_group_id' => 3,
            'name' => 'insert roles'
        ]);
        // Permission for edit roles (ADMIN)
        Permission::create([
            'permission_group_id' => 3,
            'name' => 'edit roles'
        ]);
        // Permission for delete roles (ADMIN)
        Permission::create([
            'permission_group_id' => 3,
            'name' => 'delete roles'
        ]);
        // Permission for activation roles (ADMIN)
        Permission::create([
            'permission_group_id' => 3,
            'name' => 'activation roles'
        ]);
        // Permission for check/validate roles (ADMIN)
        Permission::create([
            'permission_group_id' => 3,
            'name' => 'check roles'
        ]);

        /* ===========================================================
         USERS
        ============================================================*/
        // Permission for insert users (ADMIN)
        Permission::create([
            'permission_group_id' => 4,
            'name' => 'insert users'
        ]);
        // Permission for edit users (ADMIN)
        Permission::create([
            'permission_group_id' => 4,
            'name' => 'edit users'
        ]);
        // Permission for delete users (ADMIN)
        Permission::create([
            'permission_group_id' => 4,
            'name' => 'delete users'
        ]);
        // Permission for activation users (ADMIN)
        Permission::create([
            'permission_group_id' => 4,
            'name' => 'activation users'
        ]);
        // Permission for check/validate users (ADMIN)
        Permission::create([
            'permission_group_id' => 4,
            'name' => 'check users'
        ]);

        /* ===========================================================
         BANK CHANNELS
        ============================================================*/
        // Permission for insert bank channels (ADMIN)
        Permission::create([
            'permission_group_id' => 5,
            'name' => 'insert bank channels'
        ]);
        // Permission for edit bank channels (ADMIN)
        Permission::create([
            'permission_group_id' => 5,
            'name' => 'edit bank channels'
        ]);
        // Permission for delete bank channels (ADMIN)
        Permission::create([
            'permission_group_id' => 5,
            'name' => 'delete bank channels'
        ]);
        // Permission for activation bank channels (ADMIN)
        Permission::create([
            'permission_group_id' => 5,
            'name' => 'activation bank channels'
        ]);
        // Permission for check/validate bank channels (ADMIN)
        Permission::create([
            'permission_group_id' => 5,
            'name' => 'check bank channels'
        ]);

        /* ===========================================================
         INVITATION TYPES
        ============================================================*/
        // Permission for insert invitation types (ADMIN)
        Permission::create([
            'permission_group_id' => 6,
            'name' => 'insert invitation types'
        ]);
        // Permission for edit invitation types (ADMIN)
        Permission::create([
            'permission_group_id' => 6,
            'name' => 'edit invitation types'
        ]);
        // Permission for delete invitation types (ADMIN)
        Permission::create([
            'permission_group_id' => 6,
            'name' => 'delete invitation types'
        ]);
        // Permission for activation invitation types (ADMIN)
        Permission::create([
            'permission_group_id' => 6,
            'name' => 'activation invitation types'
        ]);
        // Permission for check/validate invitation types (ADMIN)
        Permission::create([
            'permission_group_id' => 6,
            'name' => 'check invitation types'
        ]);

        /* ===========================================================
         PAYMENT CHANNELS
        ============================================================*/
        // Permission for insert payment channels (ADMIN)
        Permission::create([
            'permission_group_id' => 7,
            'name' => 'insert payment channels'
        ]);
        // Permission for edit payment channels (ADMIN)
        Permission::create([
            'permission_group_id' => 7,
            'name' => 'edit payment channels'
        ]);
        // Permission for delete payment channels (ADMIN)
        Permission::create([
            'permission_group_id' => 7,
            'name' => 'delete payment channels'
        ]);
        // Permission for activation payment channels (ADMIN)
        Permission::create([
            'permission_group_id' => 7,
            'name' => 'activation payment channels'
        ]);
        // Permission for check/validate payment channels (ADMIN)
        Permission::create([
            'permission_group_id' => 7,
            'name' => 'check payment channels'
        ]);

        /* ===========================================================
         THEMES
        ============================================================*/
        // Permission for insert themes (ADMIN)
        Permission::create([
            'permission_group_id' => 8,
            'name' => 'insert themes'
        ]);
        // Permission for edit themes (ADMIN)
        Permission::create([
            'permission_group_id' => 8,
            'name' => 'edit themes'
        ]);
        // Permission for delete themes (ADMIN)
        Permission::create([
            'permission_group_id' => 8,
            'name' => 'delete themes'
        ]);
        // Permission for activation themes (ADMIN)
        Permission::create([
            'permission_group_id' => 8,
            'name' => 'activation themes'
        ]);
        // Permission for check/validate themes (ADMIN)
        Permission::create([
            'permission_group_id' => 8,
            'name' => 'check themes'
        ]);

        /* ===========================================================
         MUSIC
        ============================================================*/
        // Permission for insert music (ADMIN)
        Permission::create([
            'permission_group_id' => 9,
            'name' => 'insert music'
        ]);
        // Permission for edit music (ADMIN)
        Permission::create([
            'permission_group_id' => 9,
            'name' => 'edit music'
        ]);
        // Permission for delete music (ADMIN)
        Permission::create([
            'permission_group_id' => 9,
            'name' => 'delete music'
        ]);
        // Permission for check/validate music (ADMIN)
        Permission::create([
            'permission_group_id' => 9,
            'name' => 'check music'
        ]);

        /* ===========================================================
         QUOTES
        ============================================================*/
        // Permission for insert quotes (ADMIN)
        Permission::create([
            'permission_group_id' => 10,
            'name' => 'insert quotes'
        ]);
        // Permission for edit quotes (ADMIN)
        Permission::create([
            'permission_group_id' => 10,
            'name' => 'edit quotes'
        ]);
        // Permission for delete quotes (ADMIN)
        Permission::create([
            'permission_group_id' => 10,
            'name' => 'delete quotes'
        ]);
        // Permission for check/validate quotes (ADMIN)
        Permission::create([
            'permission_group_id' => 10,
            'name' => 'check quotes'
        ]);

        /* ===========================================================
         INVITATION
        ============================================================*/
        // Permission for creating an invitation (ADMIN)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'create invitation'
        ]);
        // Permission for reading all created invitation (ADMIN)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'view all invitation'
        ]);
        // Permission for edit all invitation (ADMIN)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'edit all invitation'
        ]);
        // Permission for deleting all invitation (ADMIN)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'delete all invitation'
        ]);
        // Permission for activation invitation (ADMIN)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'activation invitation'
        ]);
        // Permission for reading self created invitation (AFFILIATOR)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'view self created invitation'
        ]);
        // Permission for edit self created invitation (AFFILIATOR)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'edit self created invitation'
        ]);
        // Permission for deleting self created invitation (AFFILIATOR)
        Permission::create([
            'permission_group_id' => 11,
            'name' => 'delete self created invitation'
        ]);


        /* ===========================================================
         INVOICE
        ============================================================*/
        // Permission for view payment (ADMIN)
        Permission::create([
            'permission_group_id' => 12,
            'name' => 'view all payment'
        ]);
        // Permission for view self created invitation payment (ADMIN)
        Permission::create([
            'permission_group_id' => 12,
            'name' => 'view self created invitation payment'
        ]);
        // Permission for update invoice status (ADMIN)
        Permission::create([
            'permission_group_id' => 12,
            'name' => 'update invoice status'
        ]);


        /* ===========================================================
         SALDO
        ============================================================*/
        // Permission for view own saldo (AFFILIATOR)
        Permission::create([
            'permission_group_id' => 13,
            'name' => 'see own saldo'
        ]);
        // Permission for approvement withdrawal saldo (ADMIN)
        Permission::create([
            'permission_group_id' => 13,
            'name' => 'approvement withdrawal saldo'
        ]);
    }
}
