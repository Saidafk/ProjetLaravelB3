<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\DB;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class DescribeTable extends Tool
{
    public string $description = 'Get the schema (columns) of a specific table';

    public function schema(JsonSchema $schema): array
    {
        return [
            'table' => $schema->string()->description('The name of the table to describe'),
        ];
    }

    public function handle(Request $request): Response
    {
        $table = $request->get('table');

        if (! $table) {
            return Response::error('The [table] parameter is required.');
        }

        $columns = DB::connection()->getSchemaBuilder()->getColumnListing($table);
        $details = [];

        foreach ($columns as $column) {
            $type = DB::connection()->getSchemaBuilder()->getColumnType($table, $column);
            $details[] = [
                'name' => $column,
                'type' => $type,
            ];
        }

        return Response::json($details);
    }
}
