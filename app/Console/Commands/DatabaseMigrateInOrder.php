<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseMigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'olinvite:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migration in ordered steps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ordered migration steps
        $migrations = [
            // FRAMEWORK & VENDOR TABLES
            'database/migrations/2024_01_06_034709_create_permission_groups_table.php',
            'database/migrations/2023_12_12_222215_create_permissions_table.php',
            'database/migrations/2023_12_12_222800_create_roles_table.php',
            'database/migrations/2023_12_12_223005_create_role_permissions_table.php',
            'database/migrations/2014_10_12_000000_create_users_table.php',
            'database/migrations/2014_10_12_100000_create_password_resets_table.php', // Password reset token
            'database/migrations/2019_08_19_000000_create_failed_jobs_table.php', // Jobs
            'database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php', // Access token sanctum
            'database/migrations/2018_08_08_100000_create_telescope_entries_table.php', // Telescope
            'database/migrations/2016_08_03_072729_create_provinces_table.php', // Indonesia Provinces
            'database/migrations/2016_08_03_072750_create_cities_table.php', // Indonesia Cities
            'database/migrations/2016_08_03_072804_create_districts_table.php', // Indonesia Districts
            'database/migrations/2016_08_03_072819_create_villages_table.php', // Indonesia Village
            // APP TABLES
            'database/migrations/2023_12_13_045905_create_bank_channels_table.php',
            'database/migrations/2023_12_15_112445_create_invitation_types_table.php',
            'database/migrations/2023_12_15_113825_create_payment_channels_table.php',
            'database/migrations/2024_06_21_131604_create_form_types_table.php',
            'database/migrations/2023_12_15_114231_create_themes_table.php',
            'database/migrations/2024_06_21_132321_create_custom_forms_table.php',
            'database/migrations/2023_12_15_101349_create_music_table.php',
            'database/migrations/2024_01_20_113322_create_quotes_table.php',
            'database/migrations/2023_12_15_114703_create_invitations_table.php',
            'database/migrations/2024_06_20_041845_create_guests_table.php',
            'database/migrations/2023_12_15_115055_create_invoices_table.php',
            'database/migrations/2023_12_15_115032_create_payments_table.php',
            'database/migrations/2023_12_15_120219_create_wedding_data_table.php',
            'database/migrations/2023_12_15_122603_create_galleries_table.php',
            'database/migrations/2023_12_15_114050_create_gift_channels_table.php',
            'database/migrations/2023_12_15_122820_create_stories_table.php',
            'database/migrations/2023_12_15_123035_create_gifts_table.php',
            'database/migrations/2023_12_15_123430_create_wishes_table.php',
            'database/migrations/2024_06_20_044808_create_rsvps_table.php',
            'database/migrations/2024_06_20_043119_create_log_send_links_table.php',
            'database/migrations/2024_06_20_045704_create_log_visit_links_table.php',
            'database/migrations/2023_12_15_123856_create_wallet_affiliators_table.php',
            'database/migrations/2023_12_15_124255_create_wallet_affiliator_logs_table.php',
            'database/migrations/2023_12_15_124528_create_affiliator_withdrawals_table.php'
        ];

        // Reset Database
        $this->call('db:wipe', ['--force' => true]);

        // Run Ordered Migrations
        foreach ($migrations as $migration) {
            $this->call('migrate', [
                '--path' => $migration,
            ]);
        }

        // Seed Database
        $this->call('db:seed');

        // Seed Indonesia region table
        $this->newLine();
        $this->info('Seeding Indonesia Data...');
        $this->call('laravolt:indonesia:seed');

        // Return
        return Command::SUCCESS;
    }
}
