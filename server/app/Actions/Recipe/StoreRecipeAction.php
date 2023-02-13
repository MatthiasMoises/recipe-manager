<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Service\WeightConverterService;
use Illuminate\Http\Request;

class StoreRecipeAction
{
    // Create Recipe and add relation data
    public function execute(Request $request, WeightConverterService $weightConverter): Recipe {
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
