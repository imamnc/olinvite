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
        // Data custom forms
        $custom_forms = [
            'theme1' => [
                [
                    'form_type_id' => 3,
                    'name' => 'Image Cover',
                    'key_name' => 'image_cover',
                    'is_required' => true
                ],
                [
                    'form_type_id' => 3,
                    'name' => 'Invitation Background',
                    'key_name' => 'invitation_background',
                    'is_required' => true
                ],
                [
                    'form_type_id' => 4,
                    'name' => 'Main Slider',
                    'key_name' => 'main_slider',
                    'is_required' => true
                ],
                [
                    'form_type_id' => 3,
                    'name' => 'Wish Background',
                    'key_name' => 'wish_background',
                    'is_required' => true
                ],
            ]
        ];

        // Delete all themes files
        Storage::deleteDirectory('themes');
        // Seed themes data
        $theme_folders = Storage::disk('root')->directories('/storage/themes');
        foreach ($theme_folders as $key => $folder) {
            $path = str_replace('storage/themes/', '', $folder);
            $theme = Theme::create([
                'invitation_type_id' => 1,
                'name' => 'Theme ' . ($key + 1),
                'path' => $path,
                'thumbnails' => null,
                'price' => 100000
            ]);
            // Create custom forms
            if (isset($custom_forms[$path])) {
                foreach ($custom_forms[$path] as $cform) {
                    $theme->custom_forms()->create($cform);
                }
            }
        }
        // Copy theme assets
        $theme_files = Storage::disk('root')->allFiles('/storage/themes');
        foreach ($theme_files as $source) {
            $target = str_replace('storage/themes', 'storage/app/public/themes', $source);
            Storage::disk('root')->copy($source, $target);
        }
    }
}
