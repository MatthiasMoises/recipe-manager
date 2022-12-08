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
            'total_weight' => $this->total_weight,
            'preparation_time' => $this->preparation_time,
            'cooking_time' => $this->cooking_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
