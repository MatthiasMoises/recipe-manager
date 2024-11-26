<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class PreparationStepResource extends JsonResource
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
            "shortDescription" => $this->short_description,
            "preparationTime" => $this->preparation_time,
            "cookingTime" => $this->cooking_time,
            // "recipe_id" => $this->pivot->recipe_id
        ];
    }
}
