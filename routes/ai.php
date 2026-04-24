<?php

use App\Mcp\Servers\LaravelServer;
use Laravel\Mcp\Facades\Mcp;

/*
|--------------------------------------------------------------------------
| AI Routes
|--------------------------------------------------------------------------
*/

// On enregistre le serveur sous le nom 'laravel'
Mcp::local('laravel', LaravelServer::class);
