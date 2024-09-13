<?
namespace App\Operations;
use App\Utils\Dialog;
use App\Utils\ErrorFileUpload;

class UploadImageOperation {
  public static function process() {
    try {
      if (empty($_FILES)) {
        Dialog::show('Can not upload the file due to empty file');
        return null;
      }
      $rs = ErrorFileUpload::error($_FILES['file']['error']);
      if ($rs != 'OK') {
        Dialog::show($rs);
        return null;
      }
      // Limit the file size to 2MB
      $filemaxsize = FILE_MAX_SIZE;
      if ($_FILES['file']['size'] > $filemaxsize) {
        Dialog::show('The image size exceeds the limit of ' . $filemaxsize . ' bytes');
        return null;
      }

      // Limit the file type to image
      $mine_type = FILE_TYPE;
      // Check to make sure the file is an image 
      $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
      // upload file to temp name
      $file_mine_type = finfo_file($fileinfo, $_FILES['file']['tmp_name']);
      if (!in_array($file_mine_type, $mine_type)) {
        Dialog::show('This is not an acceptable image file type');
        return null;
      }
      
      // standardize file name before upload 
      $pathinfo = pathinfo($_FILES['file']['name']);
      $filename = $pathinfo['filename'];
      $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
      
      // handle overwriting file name exception
      $fullname = $filename . '.' . $pathinfo['extension'];
      // create the path to store the file
      $fileToHost = "./Public/uploads/recipes/{$fullname}";
      $i = 1;
      while (file_exists($fileToHost)) {
        $fullname = $filename . "-$i." . $pathinfo['extension'];
        $fileToHost =  "./Public/uploads/recipes/{$fullname}";
        $i++;
      }
      
      // move the file from temp memory to the host
      $fileTmp = $_FILES['file']['tmp_name'];
      if (move_uploaded_file($fileTmp, $fileToHost)) {
        return $fullname;
      } else {
        return null;

      }
    } catch (\Exception $e) {
      handleException($e);
      return null;
    }
  }
}
