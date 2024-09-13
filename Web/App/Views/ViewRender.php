<? 
namespace App\Views;
class ViewRender {
    const ERROR_MESSAGES = [
        400 => 'Bad Request Occurred. Please Try Again Later.',
        403 => 'Sorry, Forbidden Access. You are',
        404 => 'The Page You Requested Could Not Be Found.',
        500 => 'Sorry, Internal Server Error Occurred. Please try again later.',
        000 => 'Something Went Wrong. Please Try Again Later.'
    ];

    static public function  errorViewRender($errorCode = 000) {
        $errorCode = htmlspecialchars($errorCode, ENT_QUOTES, 'UTF-8');
        $errorMsg = self::ERROR_MESSAGES[$errorCode] ?? self::ERROR_MESSAGES[000];
        $vars = compact('errorCode', 'errorMsg');
        ob_start();
        include($_SERVER['DOCUMENT_ROOT'] . '/App/Views/pages/error_template.php');
        return ob_get_clean();
    }
}

