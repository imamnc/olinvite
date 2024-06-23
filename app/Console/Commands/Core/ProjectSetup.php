<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;

class ProjectSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'olinvite:install';

    /**
     * The console This command is for setting up olinvite project.
     *
     * @var string
     */
    protected $description = 'This is command for setting up olinivte project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Project installer title
        $this->info("=============================================");
        $this->info(" -- OLINVITE INSTALLER --");
        $this->info("=============================================");

        // Create .env files
        $this->call('olinvite:create-env');

        // Wait 5 seconds
        $this->info('Preparing to install...');
        sleep(5);
        $this->newLine();

        // Clearing cache
        $this->call('optimize:clear');
        sleep(1);

        // Run API Docs Generate
        $this->info('Generating API Documentation...');
        sleep(1);
        $this->call('olinvite:swagger-generate');

        // Generate key
        $this->info('Generating a key...');
        sleep(1);
        $this->call('key:generate');

        // Link storage
        $this->info('Linking storage path...');
        sleep(1);
        $this->call('storage:link');

        // Project install success
        $this->newLine();
        $this->newLine();
        $this->info("=============================================");
        $this->info(" -- OLINVITE INSTALLED SUCCESSFULLY --");
        $this->info("=============================================");

        // Migrate database
        $this->newLine();
        $this->comment("Please run 'php artisan olinvite:migrate' to migrate database");

        // Return
        return Command::SUCCESS;
    }
}
