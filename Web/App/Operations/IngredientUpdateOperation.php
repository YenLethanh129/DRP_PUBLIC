<?

namespace App\Operations;

use App\Utils\RedisCache;

class  IngredientUpdateOperation extends CreateAndUpdateOperation
{
  static private RedisCache $RedisCache;

  /**
   * Validates the ingredient data with specific rules.
   *
   * @param array $data The ingredient data to be validated.
   * @return void
   * @throws \InvalidArgumentException If the data is invalid.
   */
  static protected function validateData(array $data): void
  {

    /**
     * Validates the ingredient data and retrieves the valid categories, measurements, and nutrition.
     *
     * @param ValidateIngredientDataHolder $validateData The instance of ValidateIngredientDataHolder.
     * @param array $requiredFields The required fields for the ingredient.
     */
    $validateData = ValidateIngredientDataHolder::getInstance();
    $validCategories = $validateData->validCategories;
    $validMeasurements = $validateData->validMeasurements;
    $requiredFields = ['name', 'category', 'measurement_unit'];

    if ($data == null)
      throw new \InvalidArgumentException(parent::MSG_DATA_ERROR . __METHOD__ . '. 2');

    if ($validCategories == null || $validMeasurements == null)
      throw new \PDOException(parent::MSG_UNABLE_TO_VALIDATE_DATA . __METHOD__ . ". 1");


    // Check if the data is valid
    if (
      !preg_match('/^[\p{L}0-9\s.,()]+$/u', $data['name']) ||
      !in_array($data['category'], array_column($validCategories, 'id')) ||
      !in_array($data['measurement_unit'], array_column($validMeasurements, 'id'))
    ) {
      throw new \InvalidArgumentException(parent::MSG_DATA_ERROR . __METHOD__ . '. 3');
    }


    // Check if the required fields are empty
    foreach ($requiredFields as $field) {
      if (empty($data[$field])) {
        throw new \InvalidArgumentException(parent::MSG_DATA_ERROR . __METHOD__ . '. 4');
      }
    }
    // return $data;
  }


  /**
   * Save the data to the database
   *
   * @param array $data The data to be saved
   * @throws \PDOException If the data cannot be saved
   */
  static protected function saveToDatabase(array $data): void
  {
    $conn = self::getDBConnection();


    if ($conn == false) {
      throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
    }

    try {
      $conn->beginTransaction();

      // Update the ingredients table
      $insertIngredientSql = "UPDATE ingredients SET name = :name, category = :category, measurement_unit = :measurement_unit
                              WHERE id = :id";
      $ingredientStmt = $conn->prepare($insertIngredientSql);
      $ingredientStmt->execute([
        'id' => $data['id'],
        'name' => $data['name'],
        'category' => $data['category'],
        'measurement_unit' => $data['measurement_unit']
      ]);

      // Update the ingredient_nutritions table
      $insertNutritionSql = "UPDATE ingredient_nutritions SET quantity = :quantity  
                             WHERE ingredient_id = :ingredient_id AND nutrition_id = :nutrition_id";
      $stmt = $conn->prepare($insertNutritionSql);

      foreach ($data['nutritionComponents'] as $nutritionType => $nutritionValue) {
        $stmt->bindValue(':ingredient_id', $data['id'], \PDO::PARAM_INT);
        $stmt->bindValue(':nutrition_id', $nutritionType, \PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $nutritionValue, \PDO::PARAM_INT);
        $stmt->execute();
      }

      $conn->commit();
      if (!isset(
        $RedisCache
      )) {
        $RedisCache
          = new RedisCache($_ENV['REDIS'],);
      }
      $RedisCache
        ->delete('ingre_' . $data['id'] . '_with_nutri');
    } catch (\PDOException $PDOException) {
      $conn->rollBack();
      throw $PDOException;
    }
  }

  /**
   * Execute the operation
   *
   * @param array $data The data to be used in the operation
   * @return bool True if the operation was successful, false otherwise
   */
  static public function execute(array  $data): void
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

      self::notify(true, "Ingredient updated successfully!");
    } catch (\InvalidArgumentException $InvalidArgumentException) {
      self::notify(false, "Update ingredient failed caused by: invalid input. Please check your input again!");
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      self::notify(false, "Update ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Exception $Exception) {
      handleException($Exception);
      self::notify(false, "Update ingredient failed caused by: invalid data!. Please check the data and try again!");
    } catch (\Throwable $Throwable) {
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      self::notify(false, "Update ingredient failed caused by an unknown error!. We are sorry for the inconvenience!");
    }
  }

  public static function setIngredientActive($data)
  {
    try {

      /** 
       * Update the ingredient status to active or inactive
       */
      $sql = "UPDATE ingredients SET isActive = :isActive WHERE id = :id";

      /**
       * Execute the query
       */
      self::querySingle($sql, 1, ['id' => $data['id'], 'isActive' => $data['isActive']]);

      /**
       * Notify succes to the user
       */
      self::notify(true, "Ingredient status updated successfully!");
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      self::notify(false, "Update ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Throwable $Throwable) {
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      self::notify(false, "Add ingredient failed caused by an unknown error!. We are sorry for the inconvenience!");
    }
  }
}
