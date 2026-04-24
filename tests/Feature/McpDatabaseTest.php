<?php

namespace Tests\Feature;

use App\Mcp\Servers\LaravelServer;
use App\Mcp\Tools\DescribeTable;
use App\Mcp\Tools\ExecuteQuery;
use App\Mcp\Tools\ListTables;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class McpDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tables(): void
    {
        LaravelServer::tool(ListTables::class)
            ->assertOk()
            ->assertSee('users');
    }

    public function test_can_describe_table(): void
    {
        LaravelServer::tool(DescribeTable::class, ['table' => 'users'])
            ->assertOk()
            ->assertSee('email');
    }

    public function test_can_execute_select_query(): void
    {
        LaravelServer::tool(ExecuteQuery::class, ['sql' => 'SELECT 1 as result'])
            ->assertOk()
            ->assertSee('1');
    }

    public function test_cannot_execute_non_select_query(): void
    {
        LaravelServer::tool(ExecuteQuery::class, ['sql' => 'DROP TABLE users'])
            ->assertHasErrors(['Only SELECT queries are allowed']);
    }
}
