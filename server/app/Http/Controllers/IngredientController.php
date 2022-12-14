<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function getIngredientNames() {
        $ingredients = Ingredient::pluck('name')->toArray();

        return response()->json($ingredients, 200);
    }

    public function showIngredients() {
        $ingredients = Ingredient::all();

        return response()->json($ingredients, 200);
    }

    public function saveIngredient (Request $request) {
        // Validation
        $formFields = $this->validator($request);

        $ingredient = Ingredient::create($formFields);

        return response()->json($ingredient, 201);
    }

    public function updateIngredient (Request $request, $id) {
        $formFields = $this->validator($request);
        $ingredient = Ingredient::find($id);

        if ($ingredient) {
            $ingredient->update($formFields);
            return response()->json($ingredient, 200);
        } else {
            return response()->json("Ingredient $id not found", 404);
        }
    }

    public function deleteIngredient ($id) {
        if (Ingredient::destroy($id)) {
            return response()->json("Ingredient id $id deleted", 200);
        } else {
            return response()->json("Error deleting ingredient $id", 500);
        }
    }

    private function validator(Request $request) {
        return $this->validate($request, [
            'name' => 'required',
            'cup_in_grams' => 'numeric',
            'level_tablespoon_in_grams' => 'numeric',
            'heaped_tablespoon_in_grams' => 'numeric',
            'level_teaspoon_in_grams' => 'numeric'
        ]);
    }
}
