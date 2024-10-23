<?php

namespace Core;

class App
{
    protected static $container;

    //set the container
    public static function setContainer($container)
    {
        static::$container = $container;
    }

    //get the container
    public static function container()
    {
        return static::$container;
    }

    // call resolve($key) method from the stored container;
    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }
}
