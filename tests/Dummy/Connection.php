<?php

namespace Dummy;

class Connection
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
}
