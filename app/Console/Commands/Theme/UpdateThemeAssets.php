<?php

namespace App\Console\Commands\Theme;

use App\Services\ThemeService;
use Illuminate\Console\Command;

class UpdateThemeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to publish changes and update theme assets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update theme assets
        ThemeService::updateAssets();
        // Prompt success info
        $this->info('Successfully update theme assets !');
        // Return success
        return Command::SUCCESS;
    }
}
