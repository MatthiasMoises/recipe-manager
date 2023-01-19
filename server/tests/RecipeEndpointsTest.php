<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipeEndpointsTest extends TestCase
{
    use DatabaseTransactions;

    private $token = 'xCKc90BKy2K2xRJc';

    public function test_that_base_recipes_endpoint_returns_a_successful_response()
    {
        $response = $this->call('GET', '/recipe');

        $this->assertEquals(200, $response->status());
    }

    /*
    public function test_making_an_api_request_to_save_recipe_endpoint() {
        $response = $this->post( '/recipe', [
            'name' => 'Nudelsalat',
            'short_description' => 'Lecker Nudelsalat',
            'number_of_people' => 2,
            'ingredients' => $this->prepareIngredients(),
            'preparation_steps' => $this->preparePreparationSteps()
        ], ['App-Token' => $this->token]);

        $response->seeJsonContains([
            'name' => 'Nudelsalat'
        ]);
    }
    */

    /*
    public function test_making_an_api_request_to_update_recipe_endpoint() {
        $response = $this->patch( '/recipe/1', [
            'name' => 'Nudelsalat',
            'short_description' => 'Lecker Nudelsalat, improved',
            'number_of_people' => 2,
            'ingredients' => $this->prepareIngredients(),
            'preparation_steps' => $this->preparePreparationSteps()
        ], ['App-Token' => $this->token]);

        $response->seeJsonContains([
            'short_description' => 'Lecker Nudelsalat, improved',
        ]);
    }
    */

    public function test_that_single_recipe_endpoint_returns_a_successful_response()
    {
        $response = $this->call('GET', '/recipe/1');

        $this->assertEquals(200, $response->status());
    }

    public function test_making_an_api_request_to_delete_recipe_endpoint() {
        $response = $this->call('DELETE', '/recipe/1');

        $this->assertEquals(200, $response->status());
    }

    private function prepareIngredients() {
        $ingredients = array(
            array(
                "name" => "Schweinefleisch",
                "unit" => "kg",
                "amount" => "1"
            )
        );

        return json_encode($ingredients, JSON_UNESCAPED_SLASHES);
    }

    private function preparePreparationSteps () {
        $preparationSteps = array(
            array(
                "short_description" => "Klopfen",
                "preparation_time" => "5",
                "cooking_time" => "5"
            )
        );

        return json_encode($preparationSteps, JSON_UNESCAPED_SLASHES);
    }
}
