<?php

use Core\Session;

const BASE_PATH = __DIR__.'/../';

session_start();

require_once BASE_PATH . 'Core/functions.php';

//auto register (require) php files
spl_autoload_register(function ($class) {

    // convert the namespace to a file path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    // if the file exists, require it
    require_once base_path("{$class}.php");

});
require_once BASE_PATH . 'bootstrap.php';

$router = new \Core\Router();


// Check if the request is for API or Web routes
if (strpos($_SERVER['REQUEST_URI'], '/api') === 0) {
    // Load API routes
    require_once BASE_PATH .'routes/api.php';
} else {
    // Load Web routes
    require_once BASE_PATH .'routes/web.php';
}
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
//check if the request has API_KEY inside HEADER
if(isset($_SERVER['HTTP_API_KEY'])){
    // store it in the session['flash'];
    Session::flash('api_key',$_SERVER['HTTP_API_KEY']);
}

$router->route($uri, $method);

//delete all values in the ['flash'] session key
Session::unflash();


