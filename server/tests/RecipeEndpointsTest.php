<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipeEndpointsTest extends TestCase
{
    public function test_that_base_recipes_endpoint_returns_a_successful_response()
    {
        $response = $this->call('GET', '/recipe');

        $this->assertEquals(200, $response->status());
    }

    public function test_that_single_recipe_endpoint_returns_a_successful_response()
    {
        $response = $this->call('GET', '/recipe/1');

        $this->assertEquals(200, $response->status());
    }
}
