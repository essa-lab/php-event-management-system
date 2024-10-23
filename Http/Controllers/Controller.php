<?php

namespace Http\Controllers;
use Core\App;
use Core\Request;
use Core\Response;

class Controller{

    protected Request $request;
    protected Response $response;

    protected $errors;

    public function __construct(){
        $this->response = App::resolve(Response::class);

        $this->request = App::resolve(Request::class);
    }
}