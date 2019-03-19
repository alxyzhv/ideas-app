<?php

namespace app;

use app\services\Router;
use Exception;

class Application
{
    private $router;
    private $container;

    public function __construct()
    {
        $this->container = [];
        $this->router = new Router();
    }

    public function get(string $url, string $handler)
    {
        $this->router->add($url, 'GET', $handler);
    }

    public function post(string $url, string $handler)
    {
        $this->router->add($url, 'POST', $handler);
    }

    public function run()
    {
        $handler = $this->router->match();
        if (!empty($handler)) {
            try {
                [$controller, $action] = explode(':', $handler);
                if (class_exists($controller)) {
                    $controller = new $controller($this->container);
                    if (method_exists($controller, $action)) {
                        echo $controller->$action();
                        return;
                    }
                }
            } catch (Exception $e) {
                http_response_code(500);
                return;
            }
        }
        http_response_code(404);
        return;
    }

    public function __get($name)
    {
        return $this->container[$name];
    }

    public function __set($name, $value)
    {
        $this->container[$name] = $value;
    }
}
