<?php

spl_autoload_extensions('.php');
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . strtolower(str_replace('\\', '/', $class));
    spl_autoload($path);
});
