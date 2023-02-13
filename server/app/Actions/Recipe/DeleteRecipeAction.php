<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use Illuminate\Http\Request;

class DeleteRecipeAction
{
    public function execute(int $recipeId): bool {
        $recipe = Recipe::find($recipeId);

        if ($recipe) {
            // Remove data from pivot tables
            $recipe->removeIngredients();
            $recipe->removePreparationSteps();

            return $recipe->destroy($recipeId);
        }
        return false;
    }
}
