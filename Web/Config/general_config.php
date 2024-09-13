<?
// Upload file
define('FILE_MAX_SIZE', 2 * 1024 * 1024); //2MB
define('FILE_TYPE', ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/webp']); 

// Define server path
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
define('VIEWS_PATH', ROOT_PATH . 'App/Views/');
define('CONTROLLERS_PATH', ROOT_PATH . 'App/Controllers/');
define('ERRORS_PATH', ROOT_PATH . 'App/Views/errors/');
define('MODELS_PATH', ROOT_PATH . 'App/Models/');
define('CORE_PATH', ROOT_PATH . 'App/Core/');
define('UPLOAD_PATH', ROOT_PATH . 'Public/uploads/');

// Define log path file
define('DB_RELATED_LOG', ROOT_PATH . 'Journal/database-related.log');
define('ERROR_LOG', ROOT_PATH . 'Journal/errors.log');
define('EXCEPTION_LOG', ROOT_PATH . 'Journal/exceptions.log');
define('DEBUG_LOG', ROOT_PATH . 'Journal/debug.log');
define('FATAL_ERROR_LOG', ROOT_PATH . 'Journal/fatal-errors.log');

// Debug mode on
define('DEBUG', true);