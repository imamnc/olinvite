<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;

class GenerateApiDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is command for generate API Documentation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('l5-swagger:generate');
        return Command::SUCCESS;
    }
}
