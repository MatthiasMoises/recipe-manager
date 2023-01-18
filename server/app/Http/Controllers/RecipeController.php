<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\PreparationStep;
use App\Service\WeightConverterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Resources\RecipeResource;

class RecipeController extends Controller
{
    private WeightConverterService $weightConverter;

    public function __construct(WeightConverterService $weightConverter) {
        $this->weightConverter = $weightConverter;
    }

    public function showRecipes(): JsonResponse {
        $recipes = Recipe::with(['ingredients', 'preparationSteps'])->get();

        return response()->json($recipes, 200);
    }

    public function viewRecipe($id): JsonResponse {
        $recipe = new RecipeResource(Recipe::with(['ingredients', 'preparationSteps'])->find($id));

        if ($recipe) {
            return response()->json($recipe, 200);
        }
        return response()->json([], 200);
    }

    public function saveRecipe(Request $request): JsonResponse {
        // Validation
        $formFields = $this->validator($request);

        $ingredients = $formFields['ingredients'];
        $preparationSteps = $formFields['preparation_steps'];

        // Create Recipe and add relation data
        $recipe = Recipe::create($formFields);

        $recipe->addIngredients($ingredients, $this->weightConverter);
        $recipe->addPreparationSteps($preparationSteps);

        return response()->json($recipe, 201);
    }

    public function updateRecipe(Request $request, $id): JsonResponse {
        $formFields = $this->validator($request);

        $recipe = Recipe::find($id);

        if ($recipe) {
            // Just delete relating Preparation steps
            $recipe->deleteRelatedPreparationSteps();

            $ingredients = $formFields['ingredients'];
            $preparationSteps = $formFields['preparation_steps'];
            $recipe->update($formFields);

            // Remove and read relations
            $recipe->removeIngredients();
            $recipe->removePreparationSteps();

            $recipe->addIngredients($ingredients, $this->weightConverter);
            $recipe->addPreparationSteps($preparationSteps);

            return response()->json($recipe, 200);
        } else {
            return response()->json("Recipe $id not found", 404);
        }
    }

    public function deleteRecipe($id): JsonResponse {
        $recipe = Recipe::find($id);

        // Remove data from pivot tables
        $recipe->removeIngredients();
        $recipe->removePreparationSteps();

        // Delete recipe
        if ($recipe->destroy($id)) {
            return response()->json("Recipe id $id deleted", 200);
        } else {
            return response()->json("Error deleting recipe $id", 500);
        }
    }

    private function validator(Request $request): array {
        return $this->validate($request, [
            'name' => 'required',
            'short_description' => 'nullable',
            'number_of_people' => 'required|numeric',
            'ingredients' => 'required|array',
            'preparation_steps' => 'required|array'
        ]);
    }

}
