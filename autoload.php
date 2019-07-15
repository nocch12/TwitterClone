<?php

spl_autoload_register(function($class) {

    
    $class = str_replace('\\', '/', $class);
if ($class !== 'App/Exception') {
    $classFilePath = __DIR__ . '/' . $class . '.class.php';

    if(file_exists($classFilePath)) {
        require $classFilePath;
    } else {
        echo 'No such class:' . $class;
        exit;
    }
    }
});