<?php

if (!function_exists('errorHandler')) {
    function errorHandler(int $errorNo, string $errorMessage, string $errorFile, int $errorLine): void
    {
        printOutput(['Error no' => $errorNo, 'Message' => $errorMessage, 'File' => $errorFile, 'Line' => $errorLine]);
    }
}

if (!function_exists('printOutput')) {
    function printOutput(mixed $data): void
    {
        $data = is_bool($data) ? ($data ? 'true' : 'false') : (is_null($data) ? 'null' : $data);

        if (is_string($data)) {
            print_r($data);
        } else {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
}

if (!function_exists('dd')) {
    function dd(mixed $data): void
    {
        printOutput($data);
        die();
    }
}
