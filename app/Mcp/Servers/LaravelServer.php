<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\DescribeTable;
use App\Mcp\Tools\ExecuteQuery;
use App\Mcp\Tools\ListTables;
use Laravel\Mcp\Server;

class LaravelServer extends Server
{
    protected array $tools = [
        ListTables::class,
        DescribeTable::class,
        ExecuteQuery::class,
    ];

    public function boot(): void
    {
        //
    }
}
