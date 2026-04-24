<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ExecuteQuery extends Tool
{
    public string $description = 'Run a read-only SQL query (SELECT only)';

    public function schema(JsonSchema $schema): array
    {
        return [
            'sql' => $schema->string()->description('The SQL SELECT query to execute'),
        ];
    }

    public function handle(Request $request): Response
    {
        $sql = $request->get('sql');

        if (! $sql) {
            return Response::error('The [sql] parameter is required.');
        }

        $sql = trim($sql);

        if (! Str::startsWith(Str::lower($sql), 'select')) {
            return Response::error('Only SELECT queries are allowed for safety.');
        }

        try {
            $results = DB::select($sql);

            return Response::json($results);
        } catch (\Exception $e) {
            return Response::error('Query failed: '.$e->getMessage());
        }
    }
}
