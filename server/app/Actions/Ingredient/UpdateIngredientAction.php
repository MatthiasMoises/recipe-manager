<?php

namespace App\Actions\Ingredient;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class UpdateIngredientAction
{
    public function execute(Request $request, int $ingredientId): Ingredient | null {
        $ingredient = Ingredient::find($ingredientId);

        if ($ingredient) {
            $ingredient->update([
                'name' => $request->name ?? $ingredient->name,
                'cup_in_grams' => $request->cup_in_grams ?? $ingredient->cup_in_grams,
                'level_tablespoon_in_grams' => $request->level_tablespoon_in_grams ?? $ingredient->level_tablespoon_in_grams,
                'heaped_tablespoon_in_grams' => $request->heaped_tablespoon_in_grams ?? $ingredient->heaped_tablespoon_in_grams,
                'level_teaspoon_in_grams' => $request->level_teaspoon_in_grams ?? $ingredient->level_teaspoon_in_grams,
            ]);

            return $ingredient;
        }
        return null;
    }
}
