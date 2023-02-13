<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'short_description' => 'nullable',
            'number_of_people' => 'required|numeric',
            'ingredients' => 'required|array',
            'preparation_steps' => 'required|array'
        ];
    }
}
