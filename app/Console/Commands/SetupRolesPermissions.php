<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupRolesPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:permissions {--fresh : Run a fresh migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations and seeds for the roles and permissions system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up roles and permissions system...');

        if ($this->option('fresh')) {
            $this->info('Running fresh migrations...');
            Artisan::call('migrate:fresh', ['--seed' => true]);
            $this->info(Artisan::output());
        } else {
            $this->info('Running migrations...');
            Artisan::call('migrate');
            $this->info(Artisan::output());

            $this->info('Running permission seeder...');
            Artisan::call('db:seed', ['--class' => 'PermissionSeeder']);
            $this->info(Artisan::output());
        }

        $this->info('Roles and permissions setup completed successfully!');
        return Command::SUCCESS;
    }
}
