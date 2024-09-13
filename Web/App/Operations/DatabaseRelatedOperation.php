<?

namespace App\Operations;

use App\Models\IngredientModel;

class DatabaseRelatedOperation
{
  const MSG_EXECUTE_PDO_LOG = "Error: Execute the prepare statement failed - ";
  const MSG_DATA_ERROR = "Error: input data do not match with its type or be left empty - ";
  const MSG_CONNECT_PDO_EXCEPTION = "Error: Unable to establish database connection - ";

  private static $DB_CONNECTION;

  private function __construct()
  {
    if (self::$DB_CONNECTION === null) {
      $db = new \App\Core\Database();
      self::$DB_CONNECTION = $db->getConnection();
    }
  }

  protected static function getDBConnection()
  {
    if (self::$DB_CONNECTION === null) {
      new self();
    }
    return self::$DB_CONNECTION;
  }

  /**
   * Executes a database query and returns the result as an array.
   *
   * @param string $sql The SQL query to execute.
   * @param int $fetchMode The fetch mode to use. Default is fetch into .
   * @param array $params The parameters to bind to the query. Default is an empty array.
   * @param string $name The name of the class to fetch the result into. Default is null. Only used when fetchMode is 4.
   * 1 - \PDO::FETCH_ASSOC  ||  2 - \PDO::FETCH_KEY_PAIR  ||  3 - \PDO::FETCH_COLUMN | \PDO::FETCH_GROUP  || 
   * 4 - \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE  ||  5 - \PDO::FETCH_COLUMN  ||   6 - \PDO::FETCH_LAZY 
   * @return array|null The result of the query as an array, or null if the query fails.
   * @throws \PDOException If there is an error executing the query.
   * @throws \Exception If there is an error during execution.
   * @throws \Throwable If there is a throwable error during execution.
   */
  static protected function query(string $sql, int $fetchMode = 4, $params = [], string $className = null): array|bool
  {

    if (self::$DB_CONNECTION === null) {
      new self(); // Khởi tạo kết nối nếu chưa có
    }
    $conn = self::$DB_CONNECTION;

    if (self::$DB_CONNECTION == false)
      throw new \PDOException(self::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');

    $stmt = $conn->prepare($sql);

    if (!empty($params))
      foreach ($params as $key => $value) {
        if (is_numeric($value))
          $stmt->bindValue($key, $value, \PDO::PARAM_INT);
        else
          $stmt->bindValue($key, $value, \PDO::PARAM_STR);
      }


    if (!$stmt->execute()) {
      throw new \PDOException(self::MSG_EXECUTE_PDO_LOG . __METHOD__ . '. ');
    }

    if ($stmt->rowCount() > 0) {
      switch ($fetchMode) {
        case 1:
          return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Get the result as an associative arraybreak;
        case 2:
          $stmt->setFetchMode(\PDO::FETCH_KEY_PAIR); // Get the result as an associative array where the first column is the key and the second column is the value
          break;
        case 3:
          $stmt->setFetchMode(\PDO::FETCH_COLUMN | \PDO::FETCH_GROUP); // Get the result as an associative array grouped by the first column
          break;
        case 4:
          $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "App\Models\\" . $className);
          break;
        case 5:
          $stmt->setFetchMode(\PDO::FETCH_COLUMN); // To return an array consisting of all values of a single column from the result set
          break;
        case 6:
          $stmt->setFetchMode(\PDO::FETCH_LAZY); // Get the result as an array of the first column
          break;
        case 7:
          $stmt->setFetchMode(\PDO::FETCH_UNIQUE); // Get the result as an associative array where the first column is the key and the remaining columns are the values
          break;
        case 8:
          $stmt->setFetchMode(\PDO::FETCH_BOTH); // Get the result as an array of the first column
      }
    }
    return $stmt->fetchAll();
  }

  /**
   * Executes a single SQL query and returns the result based on the specified fetch mode.
   *
   * @param string $sql The SQL query to execute.
   * @param int $fetchMode The fetch mode to use. Default is 4. 
   * 1 - \PDO::FETCH_ASSOC, 2 - \PDO::FETCH_KEY_PAIR, 3 - \PDO::FETCH_COLUMN | \PDO::FETCH_GROUP,
   * 4 - \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 5 - \PDO::FETCH_COLUMN, 6 - \PDO::FETCH_LAZY
   * @param array $params An associative array of parameter values to bind to the query. Default is an empty array.
   * @param string|null $className The name of the class to fetch the result as an object. Default is null.
   * @return array|null The result of the query based on the specified fetch mode. Returns null if the query execution fails.
   * @throws \PDOException If there is an error with the database connection or query execution.
   * @throws \Exception If there is a general exception during the query execution.
   * @throws \Throwable If there is a throwable error during the query execution.
   */
  static protected function querySingle(string $sql, int $fetchMode = 0, $params = [], string $className = null)
  {
    $dbconn = new DatabaseRelatedOperation();
    $conn = self::$DB_CONNECTION;

    if ($conn == false)
      throw new \PDOException(self::MSG_CONNECT_PDO_EXCEPTION . __METHOD__ . '. ');


    $stmt = $conn->prepare($sql);

    if (!empty($params))
      foreach ($params as $key => $value)
        $stmt->bindValue($key, $value);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      switch ($fetchMode) {
        case 1:
          $stmt->setFetchMode(\PDO::FETCH_ASSOC); // Get the result as an associative array
          break;
        case 2:
          $stmt->setFetchMode(\PDO::FETCH_KEY_PAIR); // Get the result as an associative array where the first column is the key and the second column is the value
          break;
        case 3:
          $stmt->setFetchMode(\PDO::FETCH_COLUMN | \PDO::FETCH_GROUP); // Get the result as an associative array grouped by the first column
          break;
        case 4:
          $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "App\Models\\" . $className);
          break;
        case 5:
          $stmt->setFetchMode(\PDO::FETCH_COLUMN); // Get the result as an array of the first column
          break;
        case 6:
          $stmt->setFetchMode(\PDO::FETCH_LAZY); // Get the result as an array of the first column
          break;
        default:
          $stmt->setFetchMode(\PDO::FETCH_BOTH); // Get the result as an array of the first column
      }
    }
    return $stmt->fetch();
  }
}
