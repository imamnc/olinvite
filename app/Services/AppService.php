<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class AppService
{
    public static function updateTheme()
    {
        // Delete all themes files
        Storage::deleteDirectory('themes');
        // Seed themes
        $theme_files = Storage::disk('root')->allFiles('/storage/themes');
        foreach ($theme_files as $source) {
            // Copy theme assets
            $target = str_replace('storage/themes', 'storage/app/public/themes', $source);
            Storage::disk('root')->copy($source, $target);
        }
    }
}
