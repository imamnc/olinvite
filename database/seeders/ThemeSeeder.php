<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Theme 1
        Theme::create([
            'invitation_type_id' => 1,
            'name' => 'Theme 1',
            'path' => 'theme1',
            'thumbnails' => null,
            'price' => 100000
        ]);

        // Delete all themes files
        Storage::deleteDirectory('themes');
        // Copy theme files
        $theme_files = Storage::disk('root')->allFiles('/storage/themes');
        foreach ($theme_files as $source) {
            Storage::disk('root')->copy($source, str_replace('storage/themes', 'storage/app/public/themes', $source));
        }
    }
}
