<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
class StoreIngredientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'cup_in_grams' => 'numeric',
            'level_tablespoon_in_grams' => 'numeric',
            'heaped_tablespoon_in_grams' => 'numeric',
            'level_teaspoon_in_grams' => 'numeric'
        ];
    }
}
