<?

namespace App\Operations;

use App\Models\UserModel;

class UserOperation extends DatabaseRelatedOperation
{

  const TABLE = 'users';
  const CLASSMODEL = 'App\\Models\\UserModel';
  static public function check($table, $field, $data)
  {
    $sql = "select * from {$table} where {$field}=:data limit 1";
    try {
      $result = self::query($sql, 1, [':data' => $data]);
    } catch (\PDOException $PDOException) {
      handlePDOException($PDOException);
      echo \App\Views\ViewRender::errorViewRender('500');
    } catch (\Exception $exception) {
      handleException($exception);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return !empty($result);
  }

  public static function checkEmail($email)
  {
    return self::check(self::TABLE, 'email', $email);
  }
  public static function checkUserName($username)
  {
    return self::check(self::TABLE, 'username', $username);
  }

  public static function setLevel($data)
  {
    $conn = self::getDBConnection();
    $sql = "UPDATE users SET level =:level WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':level', $data['level'], \PDO::PARAM_INT);
    $stmt->bindValue(':id', $data['id'], \PDO::PARAM_INT);
    $stmt->execute();
  }


  // Main function
  public static function authenticate($data)
  {
    $conn = self::getDBConnection();

    $sql = "SELECT * FROM users where username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $data['username'], \PDO::PARAM_STR);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASSMODEL);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
      $passwordInDB = $result->getPassword();
      // Check password input with password Hash
      if (password_verify($data['password'], $passwordInDB)) {
        // Return user to get id
        $data['id'] = $result->getId();
        $_SESSION['level'] = $result->getLevel();
        $_SESSION['userId'] = $result->getId();
        return $result;
      }
    }
    // Return false if the user is not found 
    return false;
  }

  public static function addUser($data)
  {
    $conn = self::getDBConnection();

    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    try {
      $sql = "INSERT INTO users (username, password, first_name, last_name, date_of_birth, gender, email, level) values (:username, :password, :first_name, :last_name, :date_of_birth, :gender, :email, :level)";
      // Prepare the statement
      $stmt = $conn->prepare($sql);
      // Bind parameters
      $stmt->bindValue(':username', $data['username'], \PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'], \PDO::PARAM_STR);
      $stmt->bindValue(':first_name', $data['first_name'] ?? "", \PDO::PARAM_STR);
      $stmt->bindValue(':last_name', $data['last_name'] ?? "", \PDO::PARAM_STR);
      $stmt->bindValue(':date_of_birth', $data['date_of_birth'] ?? "2000-01-01", \PDO::PARAM_STR);
      $stmt->bindValue(':email', $data['email'] ?? "", \PDO::PARAM_STR);
      $stmt->bindValue(':gender', $data['gender'] ?? "male ", \PDO::PARAM_STR);
      $stmt->bindValue(':level', 3, \PDO::PARAM_INT);
      return $stmt->execute();
    } catch (\Exception $e) {
      handleException($e);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return false;
  }

  public static function update($data)
  {
    $conn = self::getDBConnection();

    $models = self::getUserById($data['id']);
    if ($data['password'] != '') {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    try {
      $sql = "UPDATE users 
      SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, date_of_birth=:date_of_birth, gender=:gender, email=:email 
      WHERE id=:id";
      $stmt = $conn->prepare($sql);
      // Bind parameters
      $stmt->bindValue(':id', $data['id'], \PDO::PARAM_INT);
      $stmt->bindValue(':username', $data['username'] != '' ? $data['username'] : $models->getUsername(), \PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'] != '' ? $data['password'] : $models->getPassword(), \PDO::PARAM_STR);
      $stmt->bindValue(':first_name', $data['first_name'] != '' ? $data['first_name'] : $models->getFirstName(), \PDO::PARAM_STR);
      $stmt->bindValue(':last_name', $data['last_name'] != '' ? $data['last_name'] : $models->getLastName(), \PDO::PARAM_STR);
      $stmt->bindValue(':date_of_birth', $data['date_of_birth'] != '' ? $data['date_of_birth'] : $models->getDateOfBirth(), \PDO::PARAM_STR);
      $stmt->bindValue(':email', $data['email'] != '' ? $data['email'] : $models->getEmail(), \PDO::PARAM_STR);
      $stmt->bindValue(':gender', $data['gender'], \PDO::PARAM_STR);
      return $stmt->execute();
    } catch (\PDOException $e) {
      handlePDOException($e);
    } catch (\Exception $e) {
      handleException($e);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
    return false;
  }

  public static function getAllUser()
  {
    $conn = self::getDBConnection();

    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASSMODEL);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function getUserById($id)
  {
    try {
      $conn = self::getDBConnection();

      $sql = "SELECT * FROM users WHERE id=:id";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
      $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASSMODEL);
      $stmt->execute();
      return $stmt->fetch();
    } catch (\PDOException $e) {
      handlePDOException($e);
    } catch (\Exception $e) {
      handleException($e);
    } catch (\Throwable $throwable) {
      handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
    }
  }

  public static function getUserByUsername($username)
  {
    $conn = self::getDBConnection();

    $sql = "SELECT * FROM users WHERE username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASSMODEL);
    $stmt->execute();
    return $stmt->fetch();
  }

  public static function getUserByEmail($email)
  {
    $conn = self::getDBConnection();

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASSMODEL);
    $stmt->execute();
    return $stmt->fetch();
  }
}
