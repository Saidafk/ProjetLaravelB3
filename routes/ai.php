<?php

use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\LaravelServer;

/*
|--------------------------------------------------------------------------
| AI Routes
|--------------------------------------------------------------------------
*/

// On enregistre le serveur sous le nom 'laravel'
Mcp::local('laravel', LaravelServer::class);
