<?php

namespace Core;

use App\Controllers\Home;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function addToRouteList($route, $params = []): void
    {
        // convert the route to a regular exp : escape forward backslash
        $route = preg_replace("/\//", '\\/', $route);
        // convert variables
        $route = preg_replace("/\{([a-z]+)\}/", '(?P<\1>[a-z-]+)', $route);
        // convert vars with custom regex e.g. {id:\d+}
        $route = preg_replace("/\{([a-z]+):([^\}]+)\}/", '(?P<\1>\2)', $route);
        // add start and end to route / i: case insensitive
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function matchURLwithRoutList($url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // get named capture group values
//                echo "<br>";
//                echo $route;
//                echo "<br>";
//                print_r($params);
//                echo "<br>";
//                print_r($matches);
//                echo "<br>";
//                echo "<br>";
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
//                print_r($params);
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        if ($this->matchURLwithRoutList($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // avoid from hard coding
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_obj = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                if (is_callable([$controller_obj, $action])) {
                    $controller_obj->$action();
                } else {
                    throw new \Exception("Method '$action' (in controller(class) '$controller') not found", 404);
                }
            } else {
                throw new \Exception("Controller(class) '$controller' not found", 404);
            }
        } else {
            throw new \Exception('no route match', 404);
        }
    }

    protected function removeQueryStringVariables($url): string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    public function convertToStudlyCaps($string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public function convertToCamelCase($string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    public function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}