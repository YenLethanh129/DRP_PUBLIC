<?
namespace App\Operations;
abstract class CreateAndUpdateOperation extends DatabaseRelatedOperation {
  const MSG_UNABLE_TO_VALIDATE_DATA = "Error: something went wrong during validate data - ";
  static protected function notify(bool $success, string $message) {
    $response = [
      'success' => $success,
      'message' => $message,
  ];

  header('Content-Type: application/json');
  // Trả về dữ liệu JSON
  echo json_encode($response);
  }
  static abstract protected function validateData(array $data) : void;
  static abstract protected function saveToDatabase(array $data) : void;
}