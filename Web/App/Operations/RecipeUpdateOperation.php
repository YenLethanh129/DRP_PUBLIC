<?

namespace App\Operations;

use App\Utils\RedisCache;

class RecipeUpdateOperation extends CreateAndUpdateOperation
{

  static private RedisCache $RedisCache;
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
      throw new \Exception("Invalid data provided in " . __METHOD__ . ". 1");
    }

    if (
      (!in_array($data['course'], array_column($validCategories1, 'id'))) ||
      (!in_array($data['meal'], array_column($validCategories2, 'id'))) ||
      (!in_array($data['method'], array_column($validCategories3, 'id')))
    ) {
      throw new \Exception("Invalid data provided in " . __METHOD__ . ". 2");
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
    $sql = "UPDATE recipes set name = :name, description = :description, preparation_time = :preparation_time, 
            cooking_time = :cooking_time, directions = :directions, course = :course, meal = :meal, method = :method "
      . (isset($data['image_url']) && !empty($data['image_url']) ? ", image_url = :image_url" : "") . " where recipes.recipe_id = :id";
    $params = [
      ':id' => $data['id'],
      ':name' => $data['name'],
      ':cooking_time' => $data['cooking_time'],
      ':preparation_time' => $data['preparation_time'],
      ':description' => $data['description'],
      ':directions' => $data['directions'],
      ':course' => $data['course'],
      ':meal' => $data['meal'],
      ':method' => $data['method']
    ];
    if (isset($data['image_url']) && !empty($data['image_url'])) {
      $params[':image_url'] = $data['image_url'];
    }
    self::query($sql, 1, $params);
    if (!isset(
      $RedisCache
    )) {
      $RedisCache
        = new RedisCache($_ENV['REDIS'],);
    }
    $RedisCache
      ->delete('recipe_' . $data['id'] . '_with_nutri');
  }


  /**
   * Execute the operation
   *
   * @param array $data The data to be used in the operation
   * @return bool True if the operation was successful, false otherwise
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

      self::notify(true, "Recipe updated successfully!");
    } catch (\InvalidArgumentException $InvalidArgumentException) {
      // Handle validation errors
      handleException($InvalidArgumentException);
      self::notify(false, "Update recipe failed caused by: invalid input. Please check your input again!");
    } catch (\PDOException $PDOException) {
      // Handle database errors
      handlePDOException($PDOException);
      self::notify(false, "Update recipe failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Exception $Exception) {
      // Handle other exceptions
      handleException($Exception);
      self::notify(false, "Update recipe failed caused by: invalid data!. Please check the data and try again!");
    } catch (\Throwable $Throwable) {
      // Handle other errors
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      self::notify(false, "Update recipe failed caused by an unknown error!. We are sorry for the inconvenience!");
    }
  }

  public static function setRecipeActive($data)
  {
    try {

      /** 
       * Update the recipe status to active or inactive
       */
      $sql = "UPDATE recipes SET isActive =:isActive WHERE recipe_id=:id";

      /**
       * Execute the query
       */
      self::querySingle($sql, 1, ['id' => $data['id'], 'isActive' => $data['isActive']]);

      /**
       * Notify succes to the user
       */
      self::notify(true, "Recipe status updated successfully!");
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      self::notify(false, "Update Recipe failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Throwable $Throwable) {
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      self::notify(false, "Add Recipe failed caused by an unknown error!. We are sorry for the inconvenience!");
    }
  }
}
