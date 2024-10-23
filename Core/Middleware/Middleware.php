<?php

namespace Core\Middleware;

class Middleware
{
    //list of the middleware
    public const MAP = [
        'authorized' => Authorized::class,
    ];

    //resolve the given middleware
    public static function resolve($key)
    {
        //if no key provided return
        if (!$key) {
            return;
        }

        //get the middleware
        $middleware = static::MAP[$key] ?? false;

        //if middlware not found thorw an exception
        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        //call handle() on the middleware
        (new $middleware)->handle();
    }
}