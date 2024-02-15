<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'olinvite:create-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for creating .env file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Delete .env file if exists
        if (Storage::disk('root')->exists('.env')) {
            Storage::disk('root')->delete('.env');
        }

        // Ask Timezone
        $app_timezone = '"UTC"';

        // Ask http protocol schema
        $http_schema = $this->choice(
            'Select your http schema',
            ['https', 'http'],
            $defaultIndex = 0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        // Ask domain name
        $domain = $this->ask('Type your domain name');

        // Ask database driver
        $db_driver = $this->choice(
            'Select your database driver',
            ['mysql', 'pgsql'],
            $defaultIndex = 0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        // Ask Database Detail
        $db_name = '"' . $this->ask('Type your database name') . '"';
        $db_host = $this->anticipate('Type your database host', ['localhost', '127.0.0.1']);
        $db_port = $this->anticipate('Type your database port', ['3306']);
        $db_user = '"' . $this->anticipate('Type your database username', ['root']) . '"';
        $db_password = '"' . $this->secret('Type your database password') . '"';

        // Read .env.example file
        $env = Storage::disk('root')->get('.env.example');

        // Fill app timezone
        $env = str_replace('[APP_TIMEZONE]', $app_timezone, $env);

        // Fill http protocol schema
        if (!empty($http_schema)) {
            $env = str_replace('[HTTP_PROTOCOL]', $http_schema, $env);
        } else {
            $env = str_replace('[HTTP_PROTOCOL]', 'http', $env);
        }

        // Fill domain name
        if (!empty($domain)) {
            $env = str_replace('olinvite.test', $domain, $env);
        }

        // Fill database data
        $env = str_replace('[DB_DRIVER]', $db_driver, $env);
        $env = str_replace('[DB_NAME]', $db_name, $env);
        $env = str_replace('[DB_HOST]', $db_host, $env);
        $env = str_replace('[DB_PORT]', $db_port, $env);
        $env = str_replace('[DB_USER]', $db_user, $env);
        $env = str_replace('[DB_PASSWORD]', $db_password, $env);

        // Create .env file
        Storage::disk('root')->put('.env', $env);

        return Command::SUCCESS;
    }
}
