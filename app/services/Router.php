<?php

namespace app\services;

class Router
{
    private $routes = [];

    public function add($uri, $method, $handler)
    {
        $this->routes[] = [
            'uri' => strtolower($uri),
            'method' => strtoupper($method),
            'handler' => $handler
        ];
    }

    public function match()
    {
        $uri = strtolower($_SERVER['REQUEST_URI']);
        $index = strpos($uri, '?');
        if ($index !== false) {
            $uri = substr($uri, 0, $index);
        }
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                return $route['handler'];
            }
        }
        return null;
    }
}
