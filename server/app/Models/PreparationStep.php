<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreparationStep extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'short_description', 'preparation_time', 'cooking_time', 'recipe_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
