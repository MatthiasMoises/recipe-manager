<?php

use \App\Http\Controllers\RecipeController;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => ['auth'], 'prefix' => 'recipe'], function () use ($router) {
    $router->get('/{id}', 'RecipeController@viewRecipe');
    $router->patch('/{id}', 'RecipeController@updateRecipe');
    $router->delete('/{id}', 'RecipeController@deleteRecipe');
    $router->post('/', 'RecipeController@saveRecipe');
    $router->get('/', 'RecipeController@showRecipes');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'ingredient'], function () use ($router) {
    $router->get('/names', 'IngredientController@getIngredientNames');
    $router->get('/{id}', 'IngredientController@viewIngredient');
    $router->put('/{id}', 'IngredientController@updateIngredient');
    $router->delete('/{id}', 'IngredientController@deleteIngredient');
    $router->post('/', 'IngredientController@saveIngredient');
    $router->get('/', 'IngredientController@showIngredients');
});
