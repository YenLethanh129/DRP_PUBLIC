<?php

namespace App\Operations;

class NutritionCalculatorOperation extends DatabaseRelatedOperation
{

  public static function calculateNutritionForRecipe($recipeId)
  {
    try {
      $conn = self::getDBConnection();

      $sql = "SELECT ir.ingredient_id, ir.quantity,ir.measurement_unit
                FROM ingredient_recipe ir
                WHERE ir.recipe_id = :recipeId";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':recipeId', $recipeId, \PDO::PARAM_INT);
      $stmt->execute();

      $totalNutrition = array(
        'calcium' => 0,
        'calories' => 0,
        'carbohydrate' => 0,
        'cholesterol' => 0,
        'fiber' => 0,
        'iron' => 0,
        'fat' => 0,
        'monounsaturated_fat' => 0,
        'polyunsaturated_fat' => 0,
        'saturated_fat' => 0,
        'potassium' => 0,
        'protein' => 0,
        'sodium' => 0,
        'sugar' => 0,
        'vitamin_a' => 0,
        'vitamin_c' => 0
      );

      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $sqlIngredient = "SELECT *
                          FROM ingredients
                          WHERE id = :ingredientId";

        $stmtIngredient = $conn->prepare($sqlIngredient);
        $stmtIngredient->bindParam(':ingredientId', $row['ingredient_id'], \PDO::PARAM_INT);
        $stmtIngredient->execute();

        $ingredient = $stmtIngredient->fetch(\PDO::FETCH_ASSOC);

        if ($ingredient === false) {
          throw new \Exception("Ingredient not found");
        }

        foreach ($totalNutrition as $key => $value) {
          if ($ingredient[$key] !== null && $row['quantity'] !== null) {
            if ($row['measurement_unit'] == 'g') {
              $totalNutrition[$key] += $ingredient[$key] * $row['quantity'] / 100;
            } else {
              $totalNutrition[$key] += $ingredient[$key] * $row['quantity'];
            }
          }
        }
      }

      return $totalNutrition;
    } catch (\PDOException $e) {
      handlePDOException($e);
    } catch (\Exception $e) {
      handleError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    }
    return null;
  }
}
