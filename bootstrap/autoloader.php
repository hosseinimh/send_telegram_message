<?php

$upDirectory = DIRECTORY_SEPARATOR . '..';
$path = __DIR__ . $upDirectory . DIRECTORY_SEPARATOR;

require_once(__DIR__ . '/../config.php');
require_once $path . 'app/helpers.php';

spl_autoload_register(function ($class) use ($path) {
    $file = $path . lcfirst(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
