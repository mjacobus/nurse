<?php

namespace Nurse;

use InvalidArgumentException;
use Closure;

class Container
{

    /**
     * @var array
     */
    private $definitions = array();

    /**
     * @var array
     */
    private $data = array();

    /**
     * Defines the factory for the single instance objects that it should
     * create on demand
     *
     * @param  string  $key     the id for the callable function
     * @param  Closure $closure the factory for the given key
     * @return self
     */
    public function set($key, Closure $closure)
    {
        if ($this->definitionExists($key)) {
            throw new InvalidArgumentException(
                "Key '$key' was already defined"
            );
        }

        $this->definitions[$key] = $closure;

        return $this;
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
            $definition = $this->getDefinition($key);
            $this->data[$key] = $definition($this);
        }

        return $this->data[$key];
    }

    /**
     * Get the definition funciton
     *
     * @param  string                    $key the definition key
     * @return callable
     * @throws \InvalidArgumentException when requested key is not set
     */
    private function getDefinition($key)
    {
        if (isset($this->definitions[$key])) {
            return $this->definitions[$key];
        }

        throw new InvalidArgumentException("'$key' was not defined");
    }

    /**
     * Check whether the definition exists
     *
     * @param  string  $key
     * @return boolean
     */
    public function definitionExists($key)
    {
        return isset($this->definitions[$key]);
    }
}
