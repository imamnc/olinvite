<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'olinvite:storage-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to clearing storage files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Prompt info
        $this->info('Clearing all files and directory in storage...');

        // Get all directories
        $allDirectories = Storage::allDirectories('/');

        // Clearing all directiories
        foreach ($allDirectories as $key => $dir) {
            // Clearing all files
            $allFiles = Storage::allFiles($dir);
            foreach ($allFiles as $key => $file) {
                if ($file != '.gitignore') {
                    Storage::delete($file);
                }
            }
            Storage::deleteDirectory($dir);
        }

        return Command::SUCCESS;
    }
}
