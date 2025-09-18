<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL; // Importer la façade URL

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
        if (
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
        ) {
            // Si c'est le cas, on force TOUTE l'application Laravel
            // à générer des URLs en https://
            // Cela résout le problème de contenu mixte qui cause le "Failed to fetch".
            URL::forceScheme('https');
        }
    }
}
