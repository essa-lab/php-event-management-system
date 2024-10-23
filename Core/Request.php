<?php

namespace Core;

class Request
{
    protected $data = [];

    // merge GET, POST, and FILES data into a single array
    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');

        if(in_array($_SERVER['REQUEST_METHOD'],['POST','PUT'] )){
            $this->data = json_decode(file_get_contents('php://input'));
        }else{
            $this->data = array_merge($_GET, $_FILES);

        }
    }

    // get all request data
    public function all()
    {
        return $this->data;
    }

    // get a specific value from the request
    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

  
    // check if a key exists in the request
    public function has($key)
    {
        return isset($this->data[$key]);
    }


}
