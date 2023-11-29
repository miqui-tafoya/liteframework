<?php

spl_autoload_register(
    function ($class) {
        $path = APP_ROOT . DIRECTORY_SEPARATOR . 'Core/App/';
        $extension = '.class.php';
        $fullPath = $path . str_replace('\\', DIRECTORY_SEPARATOR, $class) . $extension;
        require $fullPath;
    }
);