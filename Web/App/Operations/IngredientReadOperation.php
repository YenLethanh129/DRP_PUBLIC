<?php

namespace App\Operations;

use App\Utils\RedisCache;
use App\Models\IngredientModel;

class IngredientReadOperation extends ReadOperation
{


  const BASE_SQL_QUERY = "SELECT DISTINCT ingredients.id, ingredients.isActive, ingredients.name, ingredient_categories.detail AS category, ingredient_measurement_unit.detail AS measurementUnit
                          FROM ingredients 
                          LEFT JOIN ingredient_categories ON ingredients.category = ingredient_categories.id
                          LEFT JOIN ingredient_measurement_unit ON ingredients.measurement_unit = ingredient_measurement_unit.id ";
  const getSingleObjectById = self::BASE_SQL_QUERY . " WHERE ingredients.id = :id AND ingredients.isActive = 1";
  const getSingleObjectByIdIgnoreActiveMode = self::BASE_SQL_QUERY . " WHERE ingredients.id = :id";
  const getObjectsWithOffset = self::BASE_SQL_QUERY . "WHERE ingredients.isActive = 1 limit :limit offset :offset ";
  const getObjectsWithOffsetIgnoreActiveMode = self::BASE_SQL_QUERY . " limit :limit offset :offset";

  /**
   * Retrieves the nutrition components for a given ingredient ID.
   *
   * @param int $id The ID of the ingredient.
   * @return array|null An array of nutrition components or null if an error occurs.
   */
  static public function getNutrition($id): ?array
  {
    $RedisCache = parent::getRedisCache();

    $cacheKey = 'nutri_compon_' . $id;

    // Retrieve cached result
    $cachedResult = $RedisCache->get($cacheKey);

    if ($cachedResult !== null) {
      return unserialize($cachedResult);
    }

    try {
      $sql = "SELECT nutrition_types.id as nutrition_id, nutrition_types.detail AS nutrition_name, ingredient_nutritions.quantity AS nutrition_quantity
              FROM ingredient_nutritions INNER JOIN nutrition_types ON ingredient_nutritions.nutrition_id = nutrition_types.id
              WHERE ingredient_nutritions.ingredient_id = :id";

      $nutritionComponents = parent::query($sql, 1, [':id' => $id]);

      $RedisCache->set($cacheKey, serialize($nutritionComponents), 2 * 3600);

      return $nutritionComponents;
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



  /**
   * Retrieves a single object from the database based on the provided SQL query.
   *
   * @param string $sql The SQL query to execute.
   * @param bool $getNutriOrNot Determines whether to fetch nutrition components or not. Default is true.
   * @param array $params An optional array of parameters to bind to the SQL query.
   * @return IngredientModel The retrieved IngredientModel object.
   * @throws \PDOException If there is an error connecting to the database.
   * @throws \Exception If there is an error executing the SQL query.
   */

  static public function getSingleObject($sql, bool $getNutriOrNot = true, $params = []): null|IngredientModel
  {
    $RedisCache = parent::getRedisCache();

    $cacheKey = 'ingre_' . $params[':id'] . ($getNutriOrNot ? '_with_nutri' : '_without_nutri');

    $cachedResult = $RedisCache->get($cacheKey);
    if ($cachedResult !== null) {
      return unserialize($cachedResult);
    }

    $ingredient = self::querySingle($sql, 4, $params, "IngredientModel");
    if ($getNutriOrNot == true) {
      if (!is_object($ingredient)) {
        return null;
      }
      $ingredient->setNutritionComponents(self::getNutrition($ingredient->getId()));
    }

    $RedisCache
      ->set($cacheKey, serialize($ingredient), 10 * 3600);
    return $ingredient;
  }


  static private function getSingleObjectByIdInternal($id, bool $ignoreActiveStatus, bool $withoutNutri): ?IngredientModel
  {
    try {
      $sql = ($ignoreActiveStatus) ? self::getSingleObjectByIdIgnoreActiveMode : self::getSingleObjectById;

      return self::getSingleObject($sql, !$withoutNutri, [':id' => $id]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves a single IngredientModel object by its ID.
   *
   * @param $id The ID of the ingredient to retrieve.
   * @return IngredientModel|null The retrieved IngredientModel object, or null if an error occurred.
   */
  static public function getSingleObjectById($id, bool $ignoreActiveStatus = false): ?IngredientModel
  {
    return self::getSingleObjectByIdInternal($id, $ignoreActiveStatus, false);
  }


  /**
   * Retrieves a single IngredientModel object by its ID without including nutritional information.
   *
   * @param $id The ID of the ingredient to retrieve.
   * @return IngredientModel|null The retrieved IngredientModel object, or null if an error occurs.
   */
  static public function getSingleObjectByIdWithoutNutri($id, bool $ignoreActiveStatus = false): ?IngredientModel
  {
    return self::getSingleObjectByIdInternal($id, $ignoreActiveStatus, true);
  }


  /**
   * Retrieves multiple objects from the database based on the given SQL query.
   *
   * @param string $sql The SQL query to execute.
   * @param bool $getNutriOrNot Determines whether to fetch nutrition components for each ingredient. Default is true.
   * @param array $params An array of parameters to bind to the SQL query. Default is an empty array.
   * @return array An array of IngredientModel objects representing the retrieved ingredients.
   * @throws \PDOException If there is an error connecting to the database.
   * @throws \Exception If there is an error executing the SQL query.
   */
  static public function getMultipleObject($sql, bool $getNutriOrNot = true, $params = []): ?array
  {

    $RedisCache = parent::getRedisCache();

    if (isset($params[':offset']) && isset($params[':limit'])) {
      $offset = $params[':offset'];
      $limit = $params[':limit'];
      $cacheKey = 'ingre_' . $offset . '_' . $limit . ($getNutriOrNot ? '_with_nutri' : '_without_nutri');
      $cachedResult = $RedisCache
        ->get($cacheKey);
      if ($cachedResult !== null) {
        return unserialize($cachedResult);
      }
    }

    if (isset($params[':value'])) {
      $cacheKey = 'ingre_' . $params[':value'] . ($getNutriOrNot ? '_with_nutri' : '_without_nutri');
      $cachedResult = $RedisCache
        ->get($cacheKey);
      if ($cachedResult !== null) {
        return unserialize($cachedResult);
      }
    }

    $ingredients = self::query($sql, 4, $params, "IngredientModel");

    if ($getNutriOrNot === true)
      foreach ($ingredients as $ingredient)
        $ingredient->setNutritionComponents(self::getNutrition($ingredient->getId()));


    if (isset($params[':value'])) {
      $RedisCache
        ->set($cacheKey, serialize($ingredients), 10 * 3600);
    }

    if (isset($params[':offset']) && isset($params[':limit'])) {
      $RedisCache
        ->set($cacheKey, serialize($ingredients), 10 * 3600);
    }


    return $ingredients;
  }


  static private function getAllObjectsInternal(bool $ignoreActiveStatus, bool $includeNutri): ?array
  {
    try {
      $sql = self::BASE_SQL_QUERY . ($ignoreActiveStatus ? '' : ' WHERE ingredients.isActive = 1');
      return self::getMultipleObject($sql, $includeNutri);
    } catch (\PDOException $exception) {
      handleException($exception);
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return null;
  }

  /**
   * Retrieves all objects from the database.
   *
   * @return array|null An array of objects if successful, null otherwise.
   */
  static public function getAllObjects(bool $ignoreActiveStatus = false): ?array
  {
    return self::getAllObjectsInternal($ignoreActiveStatus, false);
  }


  /**
   * Retrieves all objects without nutritional information from the database.
   *
   * @return array|null An array of objects without nutritional information, or null if an error occurs.
   */
  static public function getAllObjectsWithNutri(bool $ignoreActiveStatus = false): ?array
  {
    return self::getAllObjectsInternal($ignoreActiveStatus, true);
  }


  private static function getObjectWithOffsetInternal(int $offset, ?int $limit, bool $ignoreActiveStatus, bool $includeNutri): ?array
  {
    try {
      $sql = ($ignoreActiveStatus) ? self::getObjectsWithOffsetIgnoreActiveMode : self::getObjectsWithOffset;
      return self::getMultipleObject($sql, $includeNutri, [':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $exception) {
      handleException($exception);
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
    return self::getObjectWithOffsetInternal($offset, $limit, $ignoreActiveStatus, true);
  }


  /**
   * Retrieves an array of objects with offset without including nutritional information.
   *
   * @param int $offset The starting offset for retrieving objects.
   * @param int|null $limit The maximum number of objects to retrieve. If null, defaults to offset + 5.
   * @return array|null An array of objects or null if an exception occurs.
   */
  public static function getObjectWithOffsetWithoutNutri(int $offset = 0, int $limit = null, bool $ignoreActiveStatus = false): ?array
  {
    return self::getObjectWithOffsetInternal($offset, $limit, $ignoreActiveStatus, false);
  }



  static private function getObjectByFieldAndValue(string $fieldName, $value, bool $ignoreActiveStatus, bool $includeNutri): ?array
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName = :value " . (($ignoreActiveStatus) ? "" : " AND ingredients.isActive = 1");

      return self::getMultipleObject($sql, $includeNutri, [':value' => $value]);
    } catch (\PDOException $exception) {
      handlePDOException($exception);
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
    return self::getObjectByFieldAndValue($fieldName, $value, $ignoreActiveStatus, true);
  }


  /**
   * Retrieves all ingredients without nutri info from the database table based on a specified column name and value.
   *
   * @param string $fieldName The name of the column to search for.
   * @param mixed $value The value to match in the specified column.
   * @return array|null An array of objects matching the specified column name and value, or null if an error occurred.
   */
  static public function getAllObjectsByFieldAndValueWithoutNutri(string $fieldName, $value, bool $ignoreActiveStatus = false): ?array
  {
    return self::getObjectByFieldAndValue($fieldName, $value, $ignoreActiveStatus, false);
  }


  static private function getObjectWithOffsetByFieldAndValue(string $fieldName, $value, int $offset, int $limit, bool $ignoreActiveStatus, bool $includeNutri): ?array
  {
    try {
      if ($limit === null) {
        $limit = $offset + 5;
      }

      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName = :value " . (($ignoreActiveStatus) ? "" : " AND ingredients.isActive = 1 ") . " LIMIT :limit OFFSET :offset";
      return self::getMultipleObject($sql, $includeNutri, [':value' => $value, ':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $exception) {
      handlePDOException($exception);
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
    return self::getObjectWithOffsetByFieldAndValue($fieldName, $value, $offset, $limit, $ignoreActiveStatus, true);
  }


  /**
   * Retrieves an array of ingredient without nutri info with a specified offset, field, and value.
   *
   * @param string $fieldName The name of the field to search for.
   * @param mixed $value The value to search for in the specified field.
   * @param int $offset The starting offset for retrieving the objects. Default is 0.
   * @param int|null $limit The maximum number of objects to retrieve. Default is null, which retrieves 5 objects.
   * @return array|null An array of objects matching the specified field and value, or null if an error occurs.
   */
  static public function getObjectWithOffsetByFielAndValueWithoutNutri(string $fieldName, $value, int $offset = 0, int $limit = null, bool $ignoreActiveStatus = false): ?array
  {
    return self::getObjectWithOffsetByFieldAndValue($fieldName, $value, $offset, $limit, $ignoreActiveStatus, false);
  }


  static private function getObjectForSearchingInternal(string $fieldName, $value, $ignoreActiveStatus, bool $includeNutri): ?array
  {
    try {
      $sql = self::BASE_SQL_QUERY . " WHERE $fieldName LIKE :value " . (($ignoreActiveStatus) ? "" : " AND ingredients.isActive = 1");
      return self::getMultipleObject($sql, $includeNutri, [':value' => "%$value%"]);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }

    return null;
  }
  /**
   * Returns an array of objects for searching based on the specified field name and value.
   *
   * @param string $fieldName The name of the field to search.
   * @param mixed $value The value to search for.
   * @param bool $ignoreActiveStatus (optional) Whether to ignore the active status of ingredients. Defaults to false.
   * @return array|null An array of objects matching the search criteria, or null if an error occurs.
   */
  static public function getObjectForSearching(string $fieldName, $value, $ignoreActiveStatus = false)
  {
    return self::getObjectForSearchingInternal($fieldName, $value, $ignoreActiveStatus, true);
  }


  /**
   * Retrieves objects for searching without considering nutritional information.
   *
   * @param string $fieldName The name of the field to search in.
   * @param mixed $value The value to search for.
   * @param bool $ignoreActiveStatus (optional) Whether to ignore the active status of ingredients. Defaults to false.
   * @return array|null An array of objects matching the search criteria, or null if an error occurred.
   */
  static public function getObjectForSearchingWithoutNutri(string $fieldName, $value, $ignoreActiveStatus = false)
  {
    return self::getObjectForSearchingInternal($fieldName, $value, $ignoreActiveStatus, false);
  }

  /**
   * Retrieves the ID and name of all ingredients from the database.
   *
   * @return array|null An array of associative arrays containing the ID and name of each ingredient,
   *                   or null if an error occurred.
   */
  static public function getIdAndNameAllObject(bool $ignoreActiveStatus = false): ?array
  {
    try {
      $sql = "select id, name from ingredients";

      $sql .= ($ignoreActiveStatus)  ? "" : " WHERE ingredients.isActive = 1";

      $pairs = self::query($sql, 1);
      return $pairs;
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

      // Response Ingredients data 
      return self::query($sql, 1, [':offset' => $offset, ':limit' => $limit]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      return json_encode(["error" => "Database error: " . $PDOException->getMessage()]);
    } catch (\Exception $exception) {
      handleException($exception);
      return json_encode(["error" => "Internal server error: " . $exception->getMessage()]);
    }
  }


  /**
   * Retrieves the category details based on the given ID.
   *
   * @param int $mode The mode of the find category to retrieve. 
   * 1 for ingredient_categories, 2 for nutrition_types, 3 for ingredient_measurement_unit
   * 
   * @return array|null An array containing the ID and detail of the category, or null if the ID is invalid.
   */
  static public function getCat($mode): ?array
  {
    $RedisCache = parent::getRedisCache();


    $cacheKey = 'cat_' . $mode;
    $cachedResult = $RedisCache->get($cacheKey);
    if ($cachedResult !== null) {
      return unserialize($cachedResult);
    }

    $sql = "SELECT id, detail FROM ";
    try {
      switch ($mode) {
        case 1:
          $sql .= " ingredient_categories";
          break;
        case 2:
          $sql .=  " ingredient_measurement_unit";
          break;
        case 3:
          $sql .= " nutrition_types";
          break;
        default:
          return null;
      }
      $cat = self::query($sql, 1);

      $RedisCache
        ->set($cacheKey, serialize($cat), 10 * 3600);
      return $cat;
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
}
