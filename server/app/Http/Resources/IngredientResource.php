<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class IngredientResource extends JsonResource
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
            'name' => $this->name,
            'amount' => $this->pivot->amount,
            'unit' => $this->pivot->unit,
            'amount_in_grams' => $this->pivot->amount_in_grams,
        ];
    }
}
