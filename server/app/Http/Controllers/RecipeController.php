<?php

namespace App\Http\Controllers;

use App\Actions\Recipe\DeleteRecipeAction;
use App\Actions\Recipe\StoreRecipeAction;
use App\Actions\Recipe\UpdateRecipeAction;
use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use App\Service\WeightConverterService;
use Illuminate\Http\JsonResponse;

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
        return response()->json($recipe, 200);
    }

    public function saveRecipe(StoreRecipeRequest $request, StoreRecipeAction $storeRecipeAction): JsonResponse {
        $recipe = $storeRecipeAction->execute($request, $this->weightConverter);
        return response()->json($recipe, 201);
    }

    public function updateRecipe(StoreRecipeRequest $request, UpdateRecipeAction $updateRecipeAction, $id): JsonResponse {
        $recipe = $updateRecipeAction->execute($request, $id, $this->weightConverter);

        if ($recipe) {
            return response()->json($recipe, 200);
        } else {
            return response()->json("Recipe $id not found", 404);
        }
    }

    public function deleteRecipe(DeleteRecipeAction $deleteRecipeAction, $id): JsonResponse {
        if ($deleteRecipeAction->execute($id)) {
            return response()->json("Recipe id $id deleted", 200);
        } else {
            return response()->json("Error deleting recipe $id", 500);
        }
    }
}
