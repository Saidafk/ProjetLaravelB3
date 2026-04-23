<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\MCP\Facades\Mcp;
use App\Mcp\Servers\LaravelServer;

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
        // On laisse vide ici pour éviter les conflits.
        // Tout se passe dans routes/ai.php
        Mcp::local('laravel', LaravelServer::class);
    }
}