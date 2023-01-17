<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'number_of_people' => $this->number_of_people,
            'ingredients' => IngredientResource::collection($this->ingredients),
            'preparation_steps' => PreparationStepResource::collection($this->preparationSteps),
            'total_weight' => $this->getSumTotalWeight($this->ingredients),
            'preparation_time' => $this->getSumPreparationTime($this->preparationSteps),
            'cooking_time' => $this->getSumCookingTime($this->preparationSteps),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    private function getSumTotalWeight($ingredients) {
        $totalWeight = 0;
        foreach ($ingredients as $ingredient) {
            $totalWeight += $ingredient['pivot']['amount_in_grams'];
        }
        return $totalWeight;
    }

    private function getSumPreparationTime($preparationSteps) {
        $preparationTime = 0;
        foreach ($preparationSteps as $preparationStep) {
            $preparationTime += $preparationStep['preparation_time'];
        }
        return $preparationTime;
    }

    private function getSumCookingTime($preparationSteps) {
        $cookingTime = 0;
        foreach ($preparationSteps as $preparationStep) {
            $cookingTime += $preparationStep['cooking_time'];
        }
        return $cookingTime;
    }
}
