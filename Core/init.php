<?php
// tipado fuerte
declare(strict_types=1);

// herramientas dev
/* remover de htaccess para no ver reporte de errores:
  php_flag display_startup_errors
  php_flag display_errors */
error_reporting(E_ALL); /*remover para no ver reporte de errores*/

include 'devtools.php'; /*opcional*/

// constantes primarias
define('APP_ROOT', dirname(dirname(__FILE__)));
define('COREAPP', APP_ROOT . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR);
define('APP_SUBFOLDER', 'ej/php/php-vanilla/liteframework'); /* Importante: sustrae este Path del URI al momento de Request */
define('APP_PUBLIC', APP_ROOT . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR);
define('URL_SUB', "http://localhost/ej/php/php-vanilla/liteframework" . '/');
define('URL_BASE', "http://localhost/" . APP_SUBFOLDER . '/');
define('URL_PUBLIC', URL_BASE . 'Public/');

// constantes secundarias
define('SITE_NAME', 'Lite Framework');
// define('USER_FILES', URL_PUBLIC . '' . DIRECTORY_SEPARATOR);  /*opcional*/

// constantes HTTP
const ITEMS = [
    'REDIRECT_STATUS',
    'REQUEST_METHOD',
    'DOCUMENT_ROOT',
    'REQUEST_URI',
    'QUERY_STRING'
];
$serverRequest = new class () {
    public function fetchHTTPRequest(array $items) {
        foreach ($items as $key => $value) {
            $this->returns[$value] = filter_input(INPUT_SERVER, $value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        return $this->returns;
    }
};
// include Autoload local, y de Composer en caso de haberlo
require_once 'autoload.php';
// require_once APP_PUBLIC . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Router
require_once 'routes.php';

// inicializa App
$app = new App($serverRequest->fetchHTTPRequest(ITEMS), $routeList->fetchRoutes());
