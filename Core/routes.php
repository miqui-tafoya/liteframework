<?php
// Instancia Router
use Router\RouteList;
// Instancia Controllers
use Controller\MainCtrl;

$routeList = new RouteList;
/*
  add( method, path, callback, params[layout, window-title, GET, POST], javascript[] )

  method,
  path,
  callback,
  params[layout, window-title, GET, POST],
  javascript[...]
 */

$routeList->add(
        'get',
        '/',
        'home',
        ['main', 'Hogar', ['all'], []],
        ['javascript_uno', 'javascript_cookiebar']
);

// $routeList->add(
//         'post',
//         '/',
//         'home',
//         ['main', 'Bienvenida', ['all'],  $_POST],
//         []
// );

// $routeList->add(
//         'get',
//         '/articulo/',
//         'articulo',
//         ['main', 'Articulo',  ['titulo','contenido','ads'],  []],
//         []
// );

// $routeList->add(
//         'post',
//         '/articulo/',
//         'articulo',
//         ['main', 'Articulo',  ['titulo','contenido','ads'],  $_POST],
//         []
// );

$routeList->add(
        'get',
        '/logout',
        function () {
                MainCtrl::logout();
        },
        ['', '', [], []],
        []
);

// pseudorutas y/o llamadas AJAX

// $routeList->add(
//        'post',
//        '/checar',
//        function () {
//                MainCtrl::chechar();
//        },
//        ['', '', [], []],
//        []
// );

// $routeList->add(
//        'post',
//        '/procesar',
//        function () {
//                $post = new Controlador;
//                $post->POST_AJAX();
//        },
//        ['', '', [], []],
//        []
// );

// $routeList->add(
//        'get',
//        '/ruta?set=algunget',
//        function () {
//                $get = new Trigger;
//                $get->trigger();
//        },
//        ['', '', [], []],
//        []
// );
