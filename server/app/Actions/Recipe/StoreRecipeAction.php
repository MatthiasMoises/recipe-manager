<?php

namespace App\Actions\Recipe;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use App\Service\WeightConverterService;

class StoreRecipeAction
{
    // Create Recipe and add relation data
    public function execute(StoreRecipeRequest $request, WeightConverterService $weightConverter): Recipe {
        $recipe = Recipe::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'number_of_people' => $request->number_of_people
        ]);

        $recipe->addIngredients($request->ingredients, $weightConverter);
        $recipe->addPreparationSteps($request->preparation_steps);

        return $recipe;
    }
}
