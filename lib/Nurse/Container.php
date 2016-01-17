<?php

namespace Nurse;

use Closure;
use Interop\Container\ContainerInterface;
use Nurse\Container\Exception\ContainerException;

class Container implements ContainerInterface
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
     * @param string  $key     the id for the callable function
     * @param Closure $closure the factory for the given key
     *
     * @throws DependencyAlreadyDefinedException
     *
     * @return self
     */
    public function set($key, Closure $closure)
    {
        if ($this->definitionExists($key)) {
            throw new DependencyAlreadyDefinedException(
                "Key '$key' was already defined"
            );
        }

        $this->definitions[$key] = $closure;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key the key for the
     *
     * @return mixed
     *
     * @throws UndefinedDependencyException when requested key is not set
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            $definition = $this->getDefinition($key);
            try {
                $this->data[$key] = $definition($this);
            } catch (\Exception $e) {
                throw new ContainerException(
                    "Error creating object with key 'foo'",
                    0,
                    $e
                );
            }
        }

        return $this->data[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return array_key_exists($key, $this->definitions);
    }

    /**
     * Get the definition funciton
     *
     * @param string $key the definition key
     *
     * @return callable
     *
     * @throws UndefinedDependencyException when requested key is not set
     */
    private function getDefinition($key)
    {
        if ($this->has($key)) {
            return $this->definitions[$key];
        }

        throw new UndefinedDependencyException("'$key' was not defined");
    }

    /**
     * Check whether the definition exists
     *
     * @param string $key
     *
     * @return bool
     */
    public function definitionExists($key)
    {
        return isset($this->definitions[$key]);
    }
}
