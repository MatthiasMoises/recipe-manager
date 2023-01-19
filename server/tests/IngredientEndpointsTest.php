<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IngredientEndpointsTest extends TestCase
{
    use DatabaseTransactions;

    private $token = 'xCKc90BKy2K2xRJc';

    public function test_that_names_endpoint_returns_a_successful_response() {
        $response = $this->call('GET', '/ingredient/names');

        $this->assertEquals(200, $response->status());
    }

    public function test_that_show_ingredients_endpoint_returns_a_successful_response() {
        $response = $this->call('GET', '/ingredient');

        $this->assertEquals(200, $response->status());
    }

    public function test_making_an_api_request_to_save_ingredient_endpoint() {
        $response = $this->post( '/ingredient', [
            'name' => 'OMmqaJarvP',
            'cup_in_grams' => 5,
            'level_tablespoon_in_grams' => 5,
            'heaped_tablespoon_in_grams' => 5,
            'level_teaspoon_in_grams' => 5
        ], ['App-Token' => $this->token]);

        $response->seeJsonContains([
            'name' => 'OMmqaJarvP'
        ]);
    }

    public function test_making_an_api_request_to_update_ingredient_endpoint() {
        $response = $this->put( '/ingredient/1', [
            'name' => 'YHERrQALFO',
            'cup_in_grams' => 10,
            'level_tablespoon_in_grams' => 10,
            'heaped_tablespoon_in_grams' => 10,
            'level_teaspoon_in_grams' => 10
        ], ['App-Token' => $this->token]);

        $response->seeJsonContains([
            'name' => 'YHERrQALFO',
        ]);
    }

    public function test_making_an_api_request_to_delete_ingredient_endpoint() {
        $response = $this->call('DELETE', '/ingredient/1');

        $this->assertEquals(200, $response->status());
    }

    public function test_that_seeded_ingredient_data_is_available_in_database() {
        $this->seeInDatabase('ingredients', ['name' => 'Milch']);
    }
}
