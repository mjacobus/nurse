<?php

namespace Nurse;

class Container
{

    private $definitions = array();
    private $data = array();

    public function set($a, $b)
    {
        $this->definitions[$a] = $b;
    }

    public function get($a)
    {
        if (!isset($this->data[$a])) {
            $this->data[$a] = $this->definitions[$a]();
        }
        return $this->data[$a];
    }
}
