<?php

namespace Controller;

class MainCtrl {
  public function fetchErrorController($route) {
    $route = '_' . $route;
    $buildClass = '\\Controller\\' . $route;
    $obj = new $buildClass;
    return $obj->ERROR_handler($route);
  }
  public function fetchController($route, $method) {
    if ($method == 'get') { // GET
      if (!empty($route[1][2])) {
        if (!array_key_exists('query', $route[1][2])) { // la ruta tiene query?
          $route[1][2] = $this->fetchValues($route[0], $route[1][2]); // obtiene valores GET para esta ruta
        } else {
          $query = $route[1][2]['query'];
          $values = $this->fetchValues($route[0], $route[1][2], $query); // obtiene valores GET para query de ruta dinámica
          $clean = $route[1][2];
          $callback = function ($value, $key) use (&$clean) {
            if (is_numeric($key)) {
              unset($clean[$key]);
            }
          };
          array_walk($clean, $callback);
          $route[1][2] = array_merge($values, $clean); // fusiona en un array los valores obtenidos y la orden del query original
        }
      }
      $buildClass = '\\Controller\\' . ucfirst($route[0]); // Construye Controlador para la ruta
      $obj = new $buildClass;
      return $obj->GET_handler($route[0], $route[1], $route[2]); // GET_handler(ruta, parámetros, javascript)
    } elseif ($method == 'post') { // POST
      if (!empty($route[1][2])) {
        if (!array_key_exists('query', $route[1][2])) { // la ruta tiene query?
          $route[1][2] = $this->fetchValues($route[0], $route[1][2]); // obtiene valores GET para esta ruta
        } else {
          $query = $route[1][2]['query'];
          $values = $this->fetchValues($route[0], $route[1][2], $query); // obtiene valores GET para query de ruta dinámica
          $clean = $route[1][2];
          $callback = function ($value, $key) use (&$clean) {
            if (is_numeric($key)) {
              unset($clean[$key]);
            }
          };
          array_walk($clean, $callback);
          $route[1][2] = array_merge($values, $clean);
        }
      }
      $buildClass = '\\Controller\\' . ucfirst($route[0]); // Construye Controlador para la ruta
      $obj = new $buildClass;
      return $obj->POST_handler($route[0], $route[1], $route[2]); // POST_handler(ruta, parámetros, javascript)
    }
  }
  public function fetchValues($ctrl, $params = [], $query = null) {
    $buildClass = '\\Controller\\' . ucfirst($ctrl);
    $obj = new $buildClass;
    $arr = $obj->values($params, $query);
    return $arr;
  }
  public function validateModel($route, $path) {
    $buildClass = '\\Model\\' . ucfirst($route) . 'Model';
    $obj = new $buildClass;
    return $obj->validateId((int) $path);
  }

  /////////////Funciones Personalizadas

  public static function pushAssoc($array, $key, $value) {
    $array[$key] = $value;
    return $array;
  }
  public static function emailer($msg,$tit,$to){
    $mensaje = $msg;
    $para      = $to;
    $titulo    = $tit;
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: no-reply@pymedi.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($para, $titulo, $mensaje, $cabeceras);
  }

  /////////////Logout

  public static function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: http://localhost/dir');
  }
}
