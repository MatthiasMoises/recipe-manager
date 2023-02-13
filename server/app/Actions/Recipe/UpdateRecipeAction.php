<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Service\WeightConverterService;
use Illuminate\Http\Request;

class UpdateRecipeAction
{
    public function execute(Request $request, int $recipeId, WeightConverterService $weightConverter): Recipe | null {
        $recipe = Recipe::find($recipeId);

        if ($recipe) {
            // Just delete relating Preparation steps
            $recipe->deleteRelatedPreparationSteps();

            $ingredients = $request->ingredients;
            $preparationSteps = $request->preparation_steps;
            $recipe->update([
                'name' => $request->name ?? $recipe->name,
                'short_description' => $request->short_description ?? $recipe->short_description,
                'number_of_people' => $request->number_of_people ?? $recipe->number_of_people
            ]);

            // Remove and read relations
            $recipe->removeIngredients();
            $recipe->removePreparationSteps();

            $recipe->addIngredients($ingredients, $weightConverter);
            $recipe->addPreparationSteps($preparationSteps);

            return $recipe;
        }
        return null;
    }
}
