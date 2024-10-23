<?php

use Core\App;
use Core\Container;
use Core\Database;
use Core\Request;
use Core\Response;

$container = new Container();

// set a key as 'Core\Database' that is responsible to call the builder funciton
$container->singlton('Core\Database', function () {
    $config = require base_path('config.php');

    return new Database($config['database']);
});

// set a key as 'Core\Request' that is responsible to call the builder funciton
$container->bind('Core\Request', function () {

    return new Request();
});

// set a key as 'Core\Request' that is responsible to call the builder funciton
$container->bind('Core\Response', function () {

    return new Response();
});

App::setContainer($container);
