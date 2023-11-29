<?php

namespace Model;

use Model\Database;

class HomeModel extends Model {

    public $all;

    public function __construct() {
        $this->setAll();
    }
    // GETTERS
    private function getData() {
        $data = [
            'uno' => 'dato',
            'dos' => 'dato',
        ];
        return $data;
    }
    // SETTERS
    public function setAll() {
        $data = $this->getData();
        $this->all = $data;
    }
}
