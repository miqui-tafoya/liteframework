<?php

namespace Router;

class RouteList {

    protected array $routes = [];

    public function add($method, $path, $callback, $params, $js = []) { // agrega ruta al listado y acomoda parámetros para lectura de Router
        $this->routes[$method][$path] = [$callback, $params, $js];
    }

    public function fetchRoutes() { // obtiene rutas existentes
        return $this->routes;
    }
}
