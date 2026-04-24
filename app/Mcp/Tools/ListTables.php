<?php

namespace App\Mcp\Tools;

use Illuminate\Support\Facades\DB;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ListTables extends Tool
{
    public string $description = 'List all tables in the database';

    public function handle(): Response
    {
        $tables = DB::connection()->getSchemaBuilder()->getTableListing();

        return Response::json($tables);
    }
}
