<?php

namespace Model;

abstract class Model {

    public function fetchData($data) {
        $response = [];
        foreach ($data as $key => $value) {
            if (property_exists($this, $value)) {
                $response[$value] = $this->$value;
            }
        }
        return $response;
    }
}
