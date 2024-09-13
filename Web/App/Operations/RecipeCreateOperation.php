<?

namespace App\Operations;

class RecipeCreateOperation extends CreateAndUpdateOperation
{

  /**
   * Validates the recipe data with specific rules.
   *
   * @param array $data The recipe data to be validated.
   * @return void
   * @throws \InvalidArgumentException If the data is invalid.
   * @throws \Exception If the data is missing or does not meet the validation rules.
   */
  static protected function validateData(array $data): void
  {
    // Validate data
    if ($data == null) {
      throw new \InvalidArgumentException("Invalid data provided in " . __METHOD__ . ".");
    }
    $validCategories1 = RecipeReadOperation::getCat(1);
    $validCategories2 = RecipeReadOperation::getCat(2);
    $validCategories3 = RecipeReadOperation::getCat(3);

    if (
      empty($data['name']) ||
      !preg_match('/^[\p{L}0-9\s.,()]+$/u', $data['name']) ||
      empty($data['cooking_time']) ||
      empty($data['preparation_time']) ||
      empty($data['course']) ||
      empty($data['meal']) ||
      empty($data['method']) ||
      empty($data['directions']) ||
      empty($data['description'])
    ) {
      throw new \Exception("Invalid data provided in " . __METHOD__ . ".");
    }

    if (
      (!in_array($data['course'], array_column($validCategories1, 'id'))) ||
      (!in_array($data['meal'], array_column($validCategories2, 'id'))) ||
      (!in_array($data['method'], array_column($validCategories3, 'id')))
    ) {
      throw new \Exception("Invalid data provided in " . __METHOD__ . ".");
    }

    if (
      (!in_array($data['course'], array_column($validCategories1, 'id'))) ||
      (!in_array($data['meal'], array_column($validCategories2, 'id'))) ||
      (!in_array($data['method'], array_column($validCategories3, 'id')))
    ) {
      throw new \Exception("Invalid data provided in " . __METHOD__ . ".");
    }
  }


  /**
   * Saves the recipe data to the database.
   *
   * @param array $data The recipe data to be saved.
   * @return void
   * @throws \PDOException If there is an error connecting to the database.
   */
  static protected function saveToDatabase(array $data): void
  {
    $conn = self::getDBConnection();


    // check the connection is okey? 
    if ($conn == false) {
      throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
    }

    $conn->beginTransaction();
    try {
      // Prepare the SQL query for the recipes table
      $sql = "INSERT INTO `recipes` (`user_id`, `name`, `description`, `image_url`, `preparation_time`, 
          `cooking_time`, `directions`, `course`, `meal`, `method`)
        VALUES (:user_id, :name, :description, :image_url, :preparation_time, 
          :cooking_time, :directions, :course, :meal, :method)";



      $params = [
        ':user_id' => $_SESSION['userId'],
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':image_url' => $data['image_url'] ?? null,
        ':preparation_time' => $data['preparation_time'],
        ':cooking_time' => $data['cooking_time'],
        ':directions' => $data['directions'],
        ':course' => $data['course'],
        ':meal' => $data['meal'],
        ':method' => $data['method']
      ];
      $recipeStmt = $conn->prepare($sql);
      $recipeStmt->execute($params);



      // Prepare the SQL query for the ingredient_recipe table
      $recipeId = $conn->lastInsertId();

      $sql2 = "INSERT INTO recipe_ingredient (recipe_id, ingredient_id, quantity) VALUES ";
      $values = [];
      foreach ($data['ingredientComponents'] as $component) {
        $values[] = "($recipeId, {$component['ingredient_id']}, {$component['quantity']})";
      }

      $sql2 .= implode(',', $values);
      // execute the query to insert the ingredient_recipe data
      $conn->exec($sql2);
      $conn->commit();
    } catch (\PDOException $PDOException) {
      $conn->rollBack();
      throw $PDOException;
    }
  }


  /**
   * Executes the recipe creation operation.
   *
   * @param array $data The data required for creating the recipe.
   * @return bool Returns true if the recipe is created successfully, fa    lse otherwise.
   */
  static public function execute(array $data): void
  {
    try {
      /**
       * Validate the data before saving to the database
       */
      self::validateData($data);

      /**
       * Saving data to the database process
       */
      self::saveToDatabase($data);

      // If everything goes well, set success to true and provide a success message

      self::notify(true, "Recipe create successfully!");
    } catch (\InvalidArgumentException $InvalidArgumentException) {
      // Handle validation errors
      handleException($InvalidArgumentException);
      self::notify(false, "Create recipe failed caused by: invalid input. Please check your input again!");
    } catch (\PDOException $PDOException) {
      // Handle database errors
      handlePDOException($PDOException);
      self::notify(false, "Create recipe failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Exception $Exception) {
      // Handle other exceptions
      handleException($Exception);
      self::notify(false, "Create recipe failed caused by: invalid data!. Please check the data and try again!");
    } catch (\Throwable $Throwable) {
      // Handle other errors
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      self::notify(false, "Create recipe failed caused by an unknown error!. We are sorry for the inconvenience!");
    }
  }
}
