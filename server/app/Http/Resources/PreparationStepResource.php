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
            "short_description" => $this->short_description,
            "preparation_time" => $this->preparation_time,
            "cooking_time" => $this->cooking_time,
            // "recipe_id" => $this->pivot->recipe_id
        ];
    }
}
