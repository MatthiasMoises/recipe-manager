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

    public function addIngredients($ingredients, $weightConverter) {
        foreach ($ingredients as $index => $ingredient) {
            // Check if ingredient exists already, if not, create it
            $dbIngredient = Ingredient::firstOrCreate(['name' => $ingredient['name']]);

            // Set Ingredient ID
            $ingredients[$index]['ingredient_id'] = $dbIngredient->id;

            // Convert unit if possible
            if (isset($ingredient['unit'], $ingredient['amount'])) {
                if ($dbIngredient || ($ingredient['unit'] == 'mg' || $ingredient['unit'] == 'kg' || $ingredient['unit'] == 'g')) {
                    $ingredients[$index]['amount_in_grams'] = $weightConverter->convertToGrams($ingredient['amount'], $ingredient['unit'], $dbIngredient);
                }
            }

            if (!isset($ingredients[$index]['amount_in_grams'])) {
                $ingredients[$index]['amount_in_grams'] = 0;
            }

            // No name field in pivot table
            unset($ingredients[$index]['name']);
        }

        $this->ingredients()->attach($ingredients);
    }

    public function addPreparationSteps($preparationSteps) {
        $preparationStepIds = [];
        foreach ($preparationSteps as $preparationStep) {
            $preparationStepIds[] = PreparationStep::create($preparationStep)->id;
        }
        $this->preparationSteps()->attach($preparationStepIds);
    }

    public function removeIngredients() {
        $this->ingredients()->detach();
    }

    public function removePreparationSteps() {
        $this->preparationSteps()->detach();
    }

    public function deleteRelatedPreparationSteps() {
        foreach ($this->preparationSteps()->get() as $preparationStep) {
            PreparationStep::destroy($preparationStep->id);
        }
    }
}
