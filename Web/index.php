<?php namespace App;

require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/general_config.php');
require_once(ROOT_PATH . '/App/Core/init.php');

$router = new Core\Router();
// Get Routes from routes.php
require_once(ROOT_PATH . '/Config/routes.php');

// Get URI and parse URI from Server
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// Get methods from Server
$method = $_SERVER['REQUEST_METHOD'];
// Route to the URI
$router->route($uri, $method);
