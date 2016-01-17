<?php

error_reporting(-1);
session_start();

spl_autoload_register(function ($name) {
    $namespaceToPath = str_replace('\\', DIRECTORY_SEPARATOR, $name);
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $namespaceToPath . '.php';
    if (is_file($filePath)) {
        require $filePath;
        return true;
    }
    
    return false;
});

$app = new \Application\Application();
$app->run();
