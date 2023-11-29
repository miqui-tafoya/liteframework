<?php

namespace Controller;

use View\Render;
use Model\HomeModel;

class Home extends Render {

    public function GET_handler($route, $params, $js) {
        return $this->renderView($route, $params[0], $params[1], $params[2], $params[3], $js);
        // renderView(route, layout[0], meta[1], body[2], post[3], js)
    }

    public function values($params) {
        $load = new HomeModel;
        $valores = $load->fetchData($params);
        return $valores;
    }
}