<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    // add request to the route array
    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    // save GET requests
    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    // save POST requests
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    // save DELETE requests
    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    // save PUT requests
    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    // save middlewares on the route
    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this; // enables chaining
    }

    public function route($uri, $method)
    {

        $uri = trim($uri, characters: '/');

        // loop over saved routes
        foreach ($this->routes as $route) {
            $route['uri'] = trim($route['uri'], characters: '/');

            // convert the route URI pattern to a regular expression
            // for exampel :  "/event/{id}" becomes "/event/(\w+)" to allow dynamic values
            $routePattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route['uri']);


            // check if the HTTP method matches (GET, POST, PUT , DELETe) saved in the routes
            //and the URI matches the pattern
            if ($route['method'] === strtoupper($method) && preg_match("#^$routePattern$#", $uri, $matches)) {

                // if middleware is set for the route, resolve and execute it
                try{
                    Middleware::resolve($route['middleware']);
                }catch(\Exception $e){
                    $this->handleUnAuthorizedRequests();
                }

                // $routePattern = preg_replace('/{(\w+)}/', '(\w+)', $uri);

                // remove the first element in $matches which is the full match (only need the dynamic parameters)
                array_shift($matches);

                [$controller, $method] = explode('@', $route['controller']);

                return $this->callAction($controller,$method, $matches);
            
        }
    }

    $this->abort();

    }

    protected function callAction($controller, $method, $params = [])
    {

        // full controller class name, e.g., "Http\Controllers\EventController"
        $controller = "Http\\Controllers\\{$controller}";
        // check if the controller class exists and the specified method exists in that class
        if (class_exists($controller) && method_exists($controller, $method)) {
            // call the method and pass the parameters
            return call_user_func_array([new $controller, $method], $params);
        }

        http_response_code(500);
        echo json_encode(['error' => 'Controller or method not found']);
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }

    protected function handleUnAuthorizedRequests()
    {
        App::resolve(Response::class)->error('Unauthorized',401);
    }
}
