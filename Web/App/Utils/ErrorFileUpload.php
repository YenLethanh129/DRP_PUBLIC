<?
namespace App\Utils;


class ErrorFileUpload {
  public static function error($code) {
    switch ($code) {
      case UPLOAD_ERR_OK:
        $msg = 'OK';
        break;
      case UPLOAD_ERR_INI_SIZE:
        $msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        break;
      case UPLOAD_ERR_FORM_SIZE:
        $msg = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        break;
      case UPLOAD_ERR_PARTIAL:
        $msg = 'The uploaded file was only partially uploaded';
        break;
      case UPLOAD_ERR_NO_FILE:
        $msg = 'No file was uploaded';
        break;
      case UPLOAD_ERR_NO_TMP_DIR:
        $msg = 'Missing a temporary folder';
        break;
      case UPLOAD_ERR_CANT_WRITE:
        $msg = 'Failed to write file to disk';
        break;
      case UPLOAD_ERR_EXTENSION:
        $msg = 'A PHP extension stopped the file upload';
        break;
      default:
        $msg = 'Unknown error!';
        break;
    }
    return $msg;
  }
}
