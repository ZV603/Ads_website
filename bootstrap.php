<?php

$autoloader = function ($className) {
    $parts = explode('\\', $className);
    $pathParts = array_slice($parts, 1);
    $path = implode(DIRECTORY_SEPARATOR, $pathParts);
    $sourceDirPath = '.' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $filePath =  $sourceDirPath . $path . '.php';
    if (file_exists($filePath)) {
        require $filePath;
    }
};

spl_autoload_register($autoloader);

session_start();