<?php

// Opción 1: Con dependencias en Composer
// spl_autoload_register(
//     function ($class) {
//         $loadmap = [
//             'coreapp' => APP_ROOT . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR,
//             'vendor' => APP_ROOT . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR,
//         ];
//         if (file_exists($loadmap['coreapp'] . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php')) {
//             require $loadmap['coreapp'] . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php';
//         } else if (file_exists($loadmap['coreapp'] . $class . '.php')) {
//             require $loadmap['vendor'] . $class . '.php';
//         }
//     }
// );

// Opción 2: Sin dependencias en Composer
spl_autoload_register(
    function ($class) {
        $path = APP_ROOT . DIRECTORY_SEPARATOR . 'Core/App/';
        $extension = '.class.php';
        $fullPath = $path . str_replace('\\', DIRECTORY_SEPARATOR, $class) . $extension;
        require $fullPath;
    }
);