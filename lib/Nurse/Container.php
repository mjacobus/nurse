<?php

namespace Nurse;

class Container
{

    private $definitions = array();

    private $data = array();

    /**
     * Defines the factory for the single instance objects that it should
     * create on demand
     *
     * @param  string   $key      the id for the callable function
     * @param  callable $callback the factory for the given key
     * @return self
     */
    public function set($key, $callback)
    {
        $this->definitions[$key] = $callback;
    }

    /**
     * Get the requested data. If the data is a callable function, then
     * it only executes it the fist time and caches the result
     *
     * @param  string                    $key the key for the
     * @return mixed
     * @throws \InvalidArgumentException when requested key is not set
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = $this->definitions[$key]();
        }

        return $this->data[$key];
    }
}
