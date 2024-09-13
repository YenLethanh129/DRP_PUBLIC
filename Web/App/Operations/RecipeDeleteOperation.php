<?

namespace App\Operations;

use App\Utils\RedisCache;

class RecipeDeleteOperation extends DeleteOperation
{
  private static RedisCache $RedisCache;
  static public function deleteById($id)
  {
    try {
      $conn = parent::getDBConnection();
      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }

      $sql = "DELETE FORM recipes WHERE id = :id";
      parent::querySingle($sql, 1, [':id' => $id]);
      parent::notify(true, "Recipe deleted successfully!");

      if (!isset(
        $RedisCache
      )) {
        $RedisCache
          = new RedisCache($_ENV['REDIS'],);
      }
      $RedisCache
        ->deleteKeysStartingWith('recipe_' . $id . '_with_nutri');
      return true;
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return false;
  }

  static public function deleteByFieldAndValue($fieldName, $value)
  {
    try {
      $conn = parent::getDBConnection();
      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }

      $sql = "DELETE FROM recipes WHERE $fieldName = :value";

      if (!isset(
        $RedisCache
      )) {
        $RedisCache
          = new RedisCache($_ENV['REDIS'],);
      }
      $RedisCache
        ->clear();
      return self::query($sql, 1, ['value' => $value]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      parent::notify(false, "Delete ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return false;
  }

  static public function deleteByIngredientComponent($ingredientId)
  {
    try {
      $conn = parent::getDBConnection();
      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }
      $sql = " DELETE FROM recipes WHERE `recipes`.`recipe_id` IN (SELECT `recipe_id` FROM `recipe_ingredient` WHERE `recipe_ingredient`.`ingredient_id` = :ingredientId)";
      self::query($sql, 1, ['ingredientId' => $ingredientId]);
      parent::notify(true, "Recipe deleted successfully!");
      if (!isset(
        $RedisCache
      )) {
        $RedisCache
          = new RedisCache($_ENV['REDIS'],);
      }
      $RedisCache
        ->clear();
      return true;
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return false;
  }
}
