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

        // Add ingredients
        $ingredients = $formFields['ingredients'];
        $processedIngredients = $this->processIngredients($ingredients);

        // Add preparation steps
        $preparationSteps = $formFields['preparation_steps'];
        $processedPreparationSteps = $this->processPreparationSteps($preparationSteps);

        // Create Recipe and add relation data
        $recipe = Recipe::create($formFields);
        $recipe->ingredients()->attach($processedIngredients);
        $recipe->preparationSteps()->attach($processedPreparationSteps);

        return response()->json($recipe, 201);
    }

    public function updateRecipe(Request $request, $id): JsonResponse {
        $formFields = $this->validator($request);

        $recipe = Recipe::find($id);

        if ($recipe) {
            // Add ingredients
            $ingredients = $formFields['ingredients'];
            $processedIngredients = $this->processIngredients($ingredients);

            // Just delete relating Preparation steps
            foreach ($recipe->preparationSteps as $preparationStep) {
                PreparationStep::destroy($preparationStep->id);
            }

            // Add preparation steps
            $preparationSteps = $formFields['preparation_steps'];
            $processedPreparationSteps = $this->processPreparationSteps($preparationSteps);

            $recipe->update($formFields);

            // Remove and read relations
            $this->detachRelations($recipe);

            $recipe->ingredients()->attach($processedIngredients);
            $recipe->preparationSteps()->attach($processedPreparationSteps);

            return response()->json($recipe, 200);
        } else {
            return response()->json("Recipe $id not found", 404);
        }
    }

    public function deleteRecipe($id): JsonResponse {
        $recipe = Recipe::find($id);

        // Delete relating Preparation steps
        foreach ($recipe->preparationSteps as $preparationStep) {
            PreparationStep::destroy($preparationStep->id);
        }

        // Remove data from pivot tables
        $this->detachRelations($recipe);

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

    private function processIngredients($ingredients): array{
        foreach ($ingredients as $index => $ingredient) {
            // Check if ingredient exists already, if not, create it
            $existingIngredient = Ingredient::where('name', $ingredient['name'])->first();

            if (empty($existingIngredient)) {
                $ingredientId = Ingredient::create($ingredient)->id;
            } else {
                $ingredientId = $existingIngredient->id;
            }

            // Set Ingredient ID
            $ingredients[$index]['ingredient_id'] = $ingredientId;

            // Convert unit if possible
            if (isset($ingredient['unit'], $ingredient['amount'])) {
                if ($existingIngredient || ($ingredient['unit'] == 'mg' || $ingredient['unit'] == 'kg' || $ingredient['unit'] == 'g')) {
                    $ingredients[$index]['amount_in_grams'] = $this->weightConverter->convertToGrams($ingredient['amount'], $ingredient['unit'], $existingIngredient);
                }
            }

            if (!isset($ingredients[$index]['amount_in_grams'])) {
                $ingredients[$index]['amount_in_grams'] = 0;
            }

            // No name field in pivot table
            unset($ingredients[$index]['name']);
        }

        return $ingredients;
    }

    private function processPreparationSteps($preparationSteps): array {
        $preparationStepIds = [];

        foreach ($preparationSteps as $preparationStep) {
            $preparationStepIds[] = PreparationStep::create($preparationStep)->id;
        }

        return $preparationStepIds;
    }

    private function detachRelations($recipe) {
        $recipe->ingredients()->detach();
        $recipe->preparationSteps()->detach();
    }
}
