<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register all migration directories
        $migrationDirs = [database_path('migrations')];

        foreach (File::directories(database_path('migrations')) as $directory) {
            $migrationDirs[] = $directory;
        }

        $this->loadMigrationsFrom($migrationDirs);
    }
}
