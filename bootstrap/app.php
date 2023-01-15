<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(30);

require_once(__DIR__ . '/autoloader.php');

set_error_handler('errorHandler');
