<?php

namespace App\Actions\Ingredient;

use App\Models\Ingredient;

class DeleteIngredientAction
{
    public function execute($ingredientId) : bool {
        if (Ingredient::destroy($ingredientId)) {
            return true;
        }
        return false;
    }
}
