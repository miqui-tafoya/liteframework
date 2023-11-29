<?php

namespace Controller;

use View\Render;

class _404 extends Render {

    public function ERROR_handler($route) {
        return $this->renderView($route, 'main', 'Error 404 - No Encontrado', [], [], ['script']);
    }
}
