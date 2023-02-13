<?php

namespace App\Http\Controllers;

use App\Actions\Ingredient\DeleteIngredientAction;
use App\Actions\Ingredient\StoreIngredientAction;
use App\Actions\Ingredient\UpdateIngredientAction;
use App\Http\Requests\StoreIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;

class IngredientController extends Controller
{
    public function getIngredientNames(): JsonResponse {
        $ingredients = Ingredient::pluck('name')->toArray();
        return response()->json($ingredients, 200);
    }

    public function showIngredients(): JsonResponse {
        $ingredients = Ingredient::all();
        return response()->json($ingredients, 200);
    }

    public function saveIngredient (StoreIngredientRequest $request, StoreIngredientAction $storeIngredientAction): JsonResponse {
        $ingredient = $storeIngredientAction->execute($request);
        return response()->json($ingredient, 201);
    }

    public function updateIngredient (StoreIngredientRequest $request, UpdateIngredientAction $updateIngredientAction, $id): JsonResponse {
        $ingredient = $updateIngredientAction->execute($request, $id);

        if ($ingredient) {
            return response()->json($ingredient, 200);
        } else {
            return response()->json("Ingredient $id not found", 404);
        }
    }

    public function deleteIngredient (DeleteIngredientAction $deleteIngredientAction, $id): JsonResponse {
        if ($deleteIngredientAction->execute($id)) {
            return response()->json("Ingredient id $id deleted", 200);
        } else {
            return response()->json("Error deleting ingredient $id", 500);
        }
    }
}
