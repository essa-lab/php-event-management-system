<?php

namespace Core;

use Exception;

class Container
{
    // array to save the singltons instances
    protected $singlton = [];
    //array to save the binding instances
    protected $bindings =[];
    //array to save the created instances
    protected $instances = [];

    //save into singlton array
    public function singlton($key, $resolver)
    {
        $this->singlton[$key] = $resolver;
    }

    //save into bindings array
    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    // take the instance out the container
    public  function resolve($key)
    {

        //case of -bind-
        if (array_key_exists($key, $this->bindings)) {
            // check if the resolver is callable
            if (is_callable($this->bindings[$key])) {
                // call the builder function to get the instance, to return new instance
                return $this->bindings[$key](); 
            }
            // if is not callable return it ,
            return $this->bindings[$key];
        }

        //case of -singlton-

        // if we already created the instance, return it (in case of sigleton instance)
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        // Check if the binding exists in the siglton array
        if (isset($this->singlton[$key])) {
            // call the builder function to get the instance, to return new instance
            if (is_callable($this->singlton[$key])) {
                // store the created instance to avoid multiple creations
                $this->instances[$key] = $this->singlton[$key](); 
            } else {
                // directly store the instance if it's already resolved
                $this->instances[$key] = $this->singlton[$key];
            }

            // return the newly created or stored instance
            return $this->instances[$key]; 
        }

        //no binding found, throw an exception
        throw new Exception("No matching binding found for {$key}");
    }
}