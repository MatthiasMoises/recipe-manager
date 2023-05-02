<?php

namespace App\Actions\Ingredient;

use App\Http\Requests\StoreIngredientRequest;
use App\Models\Ingredient;

class StoreIngredientAction
{
    public function execute(StoreIngredientRequest $request): Ingredient {
        $ingredient = Ingredient::create([
            'name' => $request->name,
            'cup_in_grams' => $request->cup_in_grams,
            'level_tablespoon_in_grams' => $request->level_tablespoon_in_grams,
            'heaped_tablespoon_in_grams' => $request->heaped_tablespoon_in_grams,
            'level_teaspoon_in_grams' => $request->level_teaspoon_in_grams,
        ]);

        return $ingredient;
    }
}
