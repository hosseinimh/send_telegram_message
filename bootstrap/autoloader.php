<?php

require_once(__DIR__ . '/../config.php');
require_once ABS_PATH . '/app/helpers.php';

spl_autoload_register(function ($class) {
    $file = ABS_PATH . DIRECTORY_SEPARATOR . lcfirst(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
