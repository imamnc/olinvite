<?php

namespace Database\Seeders\Collections;

use App\Models\Music;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create music
        Music::create([
            'title' => 'Beautiful in white',
            'artist' => 'West Life',
            'file_path' => 'storage/music/beautifulinwhite.mp3'
        ]);
    }
}
