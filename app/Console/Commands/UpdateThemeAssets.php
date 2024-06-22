<?php

namespace App\Console\Commands;

use App\Services\AppService;
use Illuminate\Console\Command;

class UpdateThemeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'olinvite:themeup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update theme assets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update theme
        AppService::updateTheme();
        // Prompt info
        $this->info('Successfully update theme assets !');
        // Return success
        return Command::SUCCESS;
    }
}
