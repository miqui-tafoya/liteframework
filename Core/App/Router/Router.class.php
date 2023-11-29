<?php

namespace Router;

use Controller\MainCtrl;

class Router {

    public Request $request;
    public array $server;
    public array $routeList;
    public MainCtrl $maincontroller;

    public function __construct(Request $request, array $server, array $routelist) {
        $this->request = $request;
        $this->server = $server;
        $this->routeList = $routelist;
        $this->maincontroller = new MainCtrl;
    }

    public function resolve() {
        $method = strtolower($this->server['REQUEST_METHOD']); // obtiene método solicitado: GET o POST
        $path = $this->request->getPath($this->server['REQUEST_URI']); // obtiene URI
        if (is_array($path)) { // la ruta obtenida es un array (ruta dinámica)
            $routeParameters = isset($this->routeList[$method][$path[0]]) ? $this->routeList[$method][$path[0]] : false; // existe la ruta?
            if ($routeParameters !== false) {
                $isvalid = $this->maincontroller->validateModel($routeParameters[0], $path[1]); // valida existencia del 'query' contenido en el array de la ruta dinámica
                if ($isvalid !== true) { // si ruta es inválida remite a error 404
                    $routeParameters = false;
                } else {
                    $routeParameters[1][2]['query'] = $path[1]; // agrega segundo valor de array de ruta dinámica al elemento 'query' dentro del array GET de los Parámetros de la Ruta
                }
            } else {
                $routeParameters = false; // ruta inválida
            }
        } else { // la ruta obtenida es una función (pseudoruta función)
            $routeParameters = isset($this->routeList[$method][$path]) ? $this->routeList[$method][$path] : false;
            if ($routeParameters != false) { // revisa si es nulo
                if (is_callable($routeParameters[0])) { // revisa si ruta es función
                    call_user_func($routeParameters[0]);
                    exit;
                }
            }
        }
        if ($routeParameters === false) { // la ruta obtenida no existe
            $status = 404;
            http_response_code($status);
            return $this->maincontroller->fetchErrorController($status);
        } elseif (is_string($routeParameters[0])) { // la ruta obtenida es un string (ruta estática)
            return $this->maincontroller->fetchController($routeParameters, $method);
        }
    }
}
