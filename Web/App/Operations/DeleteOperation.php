<?
namespace App\Operations;
abstract class DeleteOperation extends DatabaseRelatedOperation {
  static protected function notify(bool $success, string $message) {
    $response = [
      'success' => $success,
      'message' => $message,
  ];

  header('Content-Type: application/json');
  // Trả về dữ liệu JSON
  echo json_encode($response);
  }
  static abstract public function deleteById($id);
  static abstract public function deleteByFieldAndValue(string $fieldName, $value);
}