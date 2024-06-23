<?php

namespace Database\Seeders\Collections;

use App\Models\InvitationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvitationType::create([
            'name' => 'Wedding Invitation'
        ]);
    }
}
