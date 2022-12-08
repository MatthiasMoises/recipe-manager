<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IngredientEndpointsTest extends TestCase
{
    public function test_that_names_endpoint_returns_a_successful_response()
    {
        $response = $this->call('GET', '/ingredient/names');

        $this->assertEquals(200, $response->status());
    }

    public function test_that_seeded_ingredient_data_is_available_in_database()
    {
        $this->seeInDatabase('ingredients', ['name' => 'Milch']);
    }
}
