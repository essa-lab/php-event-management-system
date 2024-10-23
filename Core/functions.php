<?php

use Core\Response;

//dump and die function usefull for debugging
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

// check if the given value matches the requesed uri
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

// require the view that matches the given path inside the view directory
function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}
