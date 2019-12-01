<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use WithoutMiddleware;

    public function testBasicTest()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/sales_invoice');

        $this->assertEquals(200, $response->status());
    }
}
