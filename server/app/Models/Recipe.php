<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short_description', 'number_of_people',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationships
     */
    public function ingredients() {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('amount', 'unit', 'amount_in_grams');
    }

    public function preparationSteps() {
        return $this->belongsToMany('App\Models\PreparationStep');
    }
}
