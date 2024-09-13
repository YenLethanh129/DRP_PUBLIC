<?

namespace App\Operations;

use App\Models\RecipeModel;

class RecipeReadOperation extends ReadOperation
{

  const BASE_SQL_QUERY = "SELECT  
                            `user_id`, `recipe_id`, `isActive`, `name`, `preparation_time`, `cooking_time`, 
                            `recipe_meal_categories`.`type_name` AS `meal`, 
                            `recipe_method_categories`.`method_name` AS `method`, 
                            `recipe_course_categories`.`type_name` AS `course`,  
                            `image_url`, `directions` AS `direction`, `description`, `timestamp` 
                          FROM `recipes` 
                          LEFT JOIN `recipe_meal_categories` ON `recipes`.`meal` = `recipe_meal_categories`.`id`
                          LEFT JOIN `recipe_method_categories` ON `recipes`.`method` = `recipe_method_categories`.`id`
                          LEFT JOIN `recipe_course_categories` ON `recipes`.`course` = `recipe_course_categories`.`id` ";
  const getIngredientDetailsByRecipeId = "SELECT 
                                            `ingredients`.`id`, `ingredients`.`name` AS `ingredientName`, 
                                            `quantity`, `ingredient_measurement_unit`.`detail` AS `unit` 
                                          FROM `recipe_ingredient` 
                                          LEFT JOIN `ingredients` ON `recipe_ingredient`.`ingredient_id` = `ingredients`.`id`
                                          LEFT JOIN `ingredient_measurement_unit` ON `ingredients`.`measurement_unit` = `ingredient_measurement_unit`.`id`
                                          WHERE `recipe_ingredient`.`recipe_id` = :id ";

  const getSingleObjectById = self::BASE_SQL_QUERY . " WHERE recipes.recipe_id = :id AND recipes.isActive = 1";
  const getSingleObjectByIdIgnoreActiveMode = self::BASE_SQL_QUERY . " WHERE recipes.recipe_id = :id";
  const getObjectsWithOffset = self::BASE_SQL_QUERY . " WHERE recipes.isActive = 1 limit :limit offset :offset";
  const getObjectsWithOffsetIgnoreActiveMode = self::BASE_SQL_QUERY . " limit :limit offset :offset";




  /**
   * Retrieves the ingredients of a recipe based on the recipe ID.
   *
   * @param $id The ID of the recipe.
   * @return array|null An array of ingredients or null if no ingredients found.
   */
  static public function getIngredients($id): ?array
  {
    $RedisCache = parent::getRedisCache();


    $cacheKey = 'ingre_compon_' . $id;

    // Retrieve cached result
    $cachedResult = $RedisCache->get($cacheKey);

    if ($cachedResult !== null) {
      return unserialize($cachedResult);
    }
    try {

      $sql = self::getIngredientDetailsByRecipeId;
      $ingredients = self::query($sql, 1, ['id' => $id]);
      $RedisCache->set($cacheKey, serialize($ingredients), 2 * 3600);
      return $ingredients;
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  static public function getSingleObject($sql, bool $getIngreOrNot = true, $params = []): null|RecipeModel
  {
    $RedisCache = parent::getRedisCache();
    $cacheKey = 'recipe_' . $params[':id'] . ($getIngreOrNot ? '_with_ingre' : '_without_ingre');

    $RedisCache->clear();

    $cachedResult = $RedisCache->get($cacheKey);
    if ($cachedResult !== null) {
      return unserialize($cachedResult);
    }

    $recipe = self::querySingle($sql, 4, $params, "RecipeModel");

    if ($getIngreOrNot == true) {

      if (!is_object($recipe)) {
        return null;
      }

      $recipe->setIngredientComponents(self::getIngredients($recipe->getId()));
    }


    $RedisCache->set($cacheKey, serialize($recipe), 10 * 3600);
    return $recipe;
  }



  /**
   * Retrieves a single RecipeModel object by its ID.
   *
   * @param $id The ID of the ingredient to retrieve.
   * @return RecipeModel|null The retrieved RecipeModel object, or null if an error occurred.
   */
  static public function getSingleObjectById($id, bool $ignoreActiveStatus = false): ?RecipeModel
  {
    try {
      $sql = ($ignoreActiveStatus) ? self::getSingleObjectByIdIgnoreActiveMode : self::getSingleObjectById;
      return self::getSingleObject($sql, true, [':id' => $id]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
      return null;
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves a single RecipeModel object by its ID without including ingredient information.
   *
   * @param int $id The ID of the recipe to retrieve.
   * @param bool $ignoreActiveStatus (optional) Whether to ignore the active status of the recipe. Defaults to false.
   * @return RecipeModel|null The retrieved RecipeModel object, or null if an error occurred.
   */
  static public function getSingleObjectByIdWithoutIngre($id, bool $ignoreActiveStatus = false): ?RecipeModel
  {
    try {
      $sql = ($ignoreActiveStatus) ? self::getSingleObjectByIdIgnoreActiveMode : self::getSingleObjectById;
      return self::getSingleObject($sql, false, [':id' => $id]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
      return null;
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves all ingredients without nutri info from the database table based on a specified column name and value.
   *
   * @param string $fieldName The name of the column to search for.
   * @param mixed $value The value to match in the specified column.
   * @return array|null An array of objects matching the specified column name and value, or null if an error occurred.
   */
  static public function getAllObjectsByFieldAndValueWithoutIngre(string $fieldName, $value, bool $ignoreActiveStatus = false): ?array
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName = :value " . (($ignoreActiveStatus) ? "" : " AND recipes.isActive = 1");
      return self::getMultipleObject($sql, false, [':value' => $value]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  static protected function getMultipleObject($sql, bool $getIngreOrNot = true, $params = []): ?array
  {
    $recipes = self::query($sql, 4, $params, "RecipeModel");
    foreach ($recipes as $recipe) {
      if ($getIngreOrNot == true) {
        $recipe->setIngredientComponents(self::getIngredients($recipe->getId()));
      }
    }
    return $recipes;
  }


  /**
   * Retrieves all recipe recipes from the database.
   *
   * @return array|null An array of RecipeModel objects representing the recipes retrieved from the database.
   *
   * @throws \PDOException If there is an error connecting to the database.
   * @throws \Exception If there is any other exception thrown during the execution of the method.
   */
  static public function getAllObjects(bool $ignoreActiveStatus = false): ?array
  {
    try {
      $sql = ($ignoreActiveStatus) ? self::BASE_SQL_QUERY : self::BASE_SQL_QUERY . " WHERE recipes.isActive = 1";

      return self::getMultipleObject($sql);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  static public function getAllObjectsWithoutIngre(bool $ignoreActiveStatus = false): ?array
  {
    try {

      $sql = self::BASE_SQL_QUERY . (($ignoreActiveStatus) ? "" : " WHERE recipes.isActive = 1");

      return self::getMultipleObject($sql, false);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves an array of objects with an offset and optional limit.
   *
   * @param int $offset The offset value to start retrieving objects from.
   * @param int|null $limit The maximum number of objects to retrieve. If not provided, defaults to offset + 5.
   * @return array|null An array of objects retrieved with the specified offset and limit, or null if an error occurs.
   */
  public static function getObjectWithOffset(int $offset = 0, int $limit = null, bool $ignoreActiveStatus = false): ?array
  {
    try {
      if ($limit === null) {
        $limit = $offset + 5;
      }
      $sql = ($ignoreActiveStatus) ? self::getObjectsWithOffsetIgnoreActiveMode : self::getObjectsWithOffset;
      return self::getMultipleObject($sql, true, [':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves an array of objects with offset without including ingredients information.
   *
   * @param int $offset The starting offset for retrieving objects.
   * @param int|null $limit The maximum number of objects to retrieve. If null, defaults to offset + 5.
   * @return array|null An array of objects or null if an exception occurs.
   */
  public static function getObjectWithOffsetWithoutIngre(int $offset = 0, int $limit = null, bool $ignoreActiveStatus = false): ?array
  {
    try {
      if ($limit === null) {
        $limit = $offset + 5;
      }
      $sql = ($ignoreActiveStatus) ? self::getObjectsWithOffsetIgnoreActiveMode : self::getObjectsWithOffset;
      return self::getMultipleObject($sql, false, [':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }


  /**
   * Retrieves all objects from the database table based on a specified column name and value.
   *
   * @param string $fieldName The name of the column to search for.
   * @param mixed $value The value to match in the specified column.
   * @return array|null An array of objects matching the specified column name and value, or null if an error occurred.
   */
  static public function getAllObjectsByFieldAndValue(string $fieldName, $value, bool $ignoreActiveStatus = false): ?array
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE {$fieldName} = :value " . (($ignoreActiveStatus) ? "" : " AND recipes.isActive = 1");

      return self::getMultipleObject($sql, true, [':value' => $value]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }


  /**
   * Retrieves an array of objects with a specified offset, field, and value.
   *
   * @param string $fieldName The name of the field to search for.
   * @param mixed $value The value to search for in the specified field.
   * @param int $offset The starting offset for retrieving the objects. Default is 0.
   * @param int|null $limit The maximum number of objects to retrieve. Default is null, which retrieves 5 objects.
   * @return array|null An array of objects matching the specified field and value, or null if an error occurs.
   */
  static public function getObjectWithOffsetByFielAndValue(string $fieldName, $value, int $offset = 0, int $limit = null, bool $ignoreActiveStatus = false): ?array
  {
    try {
      if ($limit === null) {
        $limit = $offset + 5;
      }
      $sql = self::BASE_SQL_QUERY . " WHERE {$fieldName} = :value " . (($ignoreActiveStatus) ? "" :  " AND recipes.isActive = 1 ") .  " limit :limit offset :offset";

      return self::getMultipleObject($sql, true, [':value' => $value, ':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }



  /**
   * Returns an object for searching based on the specified field name and value.
   *
   * @param string $fieldName The name of the field to search.
   * @param mixed $value The value to search for.
   * @param bool $ignoreActiveStatus (optional) Whether to ignore the active status of recipes. Defaults to false.
   * @return mixed|null The object(s) matching the search criteria, or null if an error occurred.
   */
  static public function getObjectForSearching(string $fieldName, $value, $ignoreActiveStatus = false)
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName LIKE :value " . (($ignoreActiveStatus) ? "" : " AND recipes.isActive = 1");
      return self::getMultipleObject($sql, true, [':value' => "%$value%"]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }


  /**
   * Retrieves objects for searching without considering ingredients information.
   *
   * @param string $fieldName The name of the field to search in.
   * @param mixed $value The value to search for.
   * @param bool $ignoreActiveStatus (optional) Whether to ignore the active status of recipes. Defaults to false.
   * @return array|null An array of objects matching the search criteria, or null if an error occurred.
   */
  static public function getObjectForSearchingWithoutIngre(string $fieldName, $value, $ignoreActiveStatus = false)
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName LIKE :value " . (($ignoreActiveStatus) ? "" : " AND recipes.isActive = 1");
      return self::getMultipleObject($sql, false, [':value' => "%$value%"]);
    } catch (\PDOException $exception) {
      handleException($exception);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }


  /**
   * Retrieves the ID and name of all ingredients from the database with pagination.
   *
   * @param int $offset The starting offset for retrieving ingredients.
   * @param int|null $limit The maximum number of ingredients to retrieve. If not provided, defaults to offset + 5.
   */
  static public function getPaging(int $offset, int $limit = null, bool $ignoreActiveStatus = false)
  {
    try {
      if ($limit === null) {
        $limit = $offset + 10;
      }

      $sql = ($ignoreActiveStatus) ? self::getObjectsWithOffsetIgnoreActiveMode : self::getObjectsWithOffset;

      // Fetch Data
      $data = self::query($sql, 1, [':offset' => $offset, ':limit' => $limit]);

      // Response data JSON
      return json_encode($data);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      return json_encode(["error" => "Database error: " . $PDOException->getMessage()]);
    } catch (\Exception $exception) {
      handleException($exception);
      return json_encode(["error" => "Internal server error: " . $exception->getMessage()]);
    }
  }


  /**
   * Retrieves a list of recipes from the database based on the given field and value.
   *
   * @param string $field The name of the field to search for.
   * @param mixed $value The value to match against the field.
   * @return string The JSON-encoded response containing the retrieved recipes.
   * @throws \PDOException If there is an error connecting to the database.
   * @throws \Exception If there is an internal server error.
   */
  static public function getRecipeByIngredientFieldAndValue(string $field, $value): ?array
  {
    try {
      $conn = parent::getDBConnection();

      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }
      $sql = "SELECT `recipes`.`recipe_id` AS recipeId , `recipes`.`name` AS recipeName 
              FROM `recipe_ingredient` 
              LEFT JOIN `recipes` ON `recipe_ingredient`.`recipe_id` = `recipes`.`recipe_id`
              LEFT JOIN `ingredients` ON `recipe_ingredient`.`ingredient_id` = `ingredients`.`id`
              WHERE `ingredients`.{$field} = :value";

      return self::query($sql, 1, [':value' => $value]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }



  static public function getCat($mode)
  {
    try {
      switch ($mode) {
        case 1:
          return self::query("SELECT `id`, `type_name` FROM `recipe_course_categories`", 1);
        case 2:
          return self::query("SELECT `id`, `type_name` FROM `recipe_meal_categories`", 1);
        case 3:
          return self::query("SELECT `id`, `method_name` FROM `recipe_method_categories`", 1);
      }
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }
}
