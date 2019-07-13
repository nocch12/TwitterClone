<?php

spl_autoload_register(function($class) {

    $class = str_replace('\\', '/', $class);

    $classFilePath = __DIR__ . '/' . $class . '.class.php';

    if(file_exists($classFilePath)) {
        require $classFilePath;
    } else {
        echo 'No such class:' . $className;
        exit;
    }
});