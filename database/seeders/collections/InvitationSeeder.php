<?php

namespace Database\Seeders\Collections;

use App\Models\Invitation;
use App\Models\Story;
use App\Models\Theme;
use App\Services\SeederService;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all invitations files
        Storage::deleteDirectory('invitations');

        // Seed invitation example 1 (Theme 1)
        SeederService::theme1();
    }
}
