<?

namespace App\Operations;

use App\Utils\RedisCache;

class IngredientDeleteOperation extends DeleteOperation
{

  static public function deleteById($id)
  {
    try {
      $conn = parent::getDBConnection();

      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }

      $sql = "DELETE FROM ingredients WHERE id = :id";

      /**
       * Execute the query
       */
      parent::querySingle($sql, 1, [':id' => $id]);

      /**
       * Notify succes to the user
       */
      self::notify(true, "Ingredient status deleted successfully!");

      if (!isset(
        $RedisCache
      )) {
        $RedisCache
          = new RedisCache($_ENV['REDIS'],);
      }
      $RedisCache
        ->delete('ingre_' . $id . '_with_nutri');
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      parent::notify(false, "Delete ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Throwable $Throwable) {
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      parent::notify(false, "Delete ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    }
  }

  static public function deleteByFieldAndValue(string $fieldName, $value): bool
  {
    try {
      $conn = parent::getDBConnection();

      if ($conn == false) {
        throw new \PDOException(parent::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');
      }

      $sql = "DELETE FROM ingredients WHERE $fieldName = :value";
      parent::query($sql, 1, [':value' => $value]);
      parent::notify(true, "Ingredient deleted successfully!");
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      parent::notify(false, "Delete ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    } catch (\Throwable $Throwable) {
      handleError($Throwable->getCode(), $Throwable->getMessage(), $Throwable->getFile(), $Throwable->getLine());
      parent::notify(false, "Delete ingredient failed caused by: Unknown errors! We are sorry for the inconvenience!");
    }
    return false;
  }
}
