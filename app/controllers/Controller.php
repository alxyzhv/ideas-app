<?php

namespace app\controllers;

class Controller
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        return $this->container[$name];
    }

    protected function getParam($key, $default = null)
    {
        if (!empty($_GET) && isset($_GET[$key])) {
            return $_GET[$key];
        }

        if (!empty($_POST) && isset($_POST[$key])) {
            return $_POST[$key];
        }

        $input = file_get_contents('php://input');
        $body = json_decode($input);
        if (isset($body->$key)) {
            return $body->$key;
        }

        return $default;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }
}
