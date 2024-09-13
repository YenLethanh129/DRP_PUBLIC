<?php

namespace App\Core;

use App\Controllers\BaseController;

class Router
{
    protected $routes = [];

    private function add($method, $uri, $controller, $params = [])
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'params' => $params
        ];
    }

    public function get($uri, $controller, $params = [])
    {
        $this->add('GET', $uri, $controller, $params);
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }
    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        $this->add('PATCH', $uri, $controller);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == strtoupper($method)) {
                $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['uri']);
                if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                    $controller_action = $route['controller'];
                    list($controller, $action) = explode('@', $controller_action);

                    $controller = "App\\Controllers\\$controller";
                    $controller_instance = new $controller();

                    // Pass parameters to controller action
                    $params = array_slice($matches, 1);
                    call_user_func_array([$controller_instance, $action], $params);

                    return null;
                }
            }
        }

        BaseController::loadError('404');
    }
}
