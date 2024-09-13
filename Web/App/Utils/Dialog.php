<?
namespace App\Utils;

class Dialog {
  public static function show($msg) {
    echo "<script>alert('$msg')</script>";
  }
}
