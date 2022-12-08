<?php

namespace App\Traits;

use App\Models\Ingredient;

trait WeightConverter
{
    public function convertToGrams($amount, $unit, Ingredient $ingredient = null) {
        switch ($unit) {
            case 'mg':
                $gramsValue = $amount / 1000;
                break;
            case 'kg':
                $gramsValue = $amount * 1000;
                break;
            case 'TL':
                $gramsValue = $ingredient->level_teaspoon_in_grams * $amount;
                break;
            case 'EL':
                if (str_contains($ingredient, 'gehäuft')) {
                    $gramsValue = $ingredient->heaped_tablespoon_in_grams * $amount;
                } else {
                    $gramsValue = $ingredient->level_tablespoon_in_grams * $amount;
                }
                break;
            case 'Tasse':
                $gramsValue = $ingredient->cup_in_grams * $amount;
                break;
            default:
                $gramsValue = $amount;
        }
        return $gramsValue;
    }
}
