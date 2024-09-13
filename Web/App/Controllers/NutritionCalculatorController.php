<?php

namespace App\Controllers;
use App\Operations\NutritionCalculatorOperation;

class NutritionCalculatorController
{
    public function calculateNutrition()
    {
        $recipeId = $_GET('id');

        $nutrition = NutritionCalculatorOperation::calculateNutritionForRecipe($recipeId);

        if ($nutrition !== null) {
            return $nutrition;
        } else {
            return null;
        }
    }
}
