<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Pastikan variabel environment Windows (SystemRoot, windir, dll.) tidak dihapus oleh php artisan serve
        if (getenv('SystemRoot')) {
            $_ENV['SystemRoot'] = getenv('SystemRoot');
            $_ENV['SYSTEMROOT'] = getenv('SystemRoot');
        }

        ServeCommand::$passthroughVariables = array_values(array_unique(array_merge(
            ServeCommand::$passthroughVariables,
            ['SystemRoot', 'SYSTEMROOT', 'windir', 'WINDIR', 'COMSPEC', 'ComSpec', 'PATH', 'Path', 'TEMP', 'TMP']
        )));

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
