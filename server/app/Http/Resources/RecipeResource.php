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
            'shortDescription' => $this->short_description,
            'numberOfPeople' => $this->number_of_people,
            'ingredients' => IngredientResource::collection($this->ingredients),
            'preparationSteps' => PreparationStepResource::collection($this->preparationSteps),
            'totalWeight' => $this->getSumTotalWeight($this->ingredients),
            'preparationTime' => $this->getSumPreparationTime($this->preparationSteps),
            'cookingTime' => $this->getSumCookingTime($this->preparationSteps),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
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
