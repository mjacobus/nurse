<?php

namespace Nurse;

use Closure;
use Nurse\Container\Exception\ContainerException;
use Nurse\Container\Exception\DependencyAlreadyDefinedException;
use Nurse\Container\Exception\UndefinedDependencyException;
use Nurse\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $definitions = [];

    /**
     * @var array
     */
    private $data = [];

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
     * @param FactoryInterface $factory
     *
     * @return self
     */
    public function addFactory(FactoryInterface $factory)
    {
        $container = $this;

        $callback = function () use ($factory, $container) {
            return $factory->createService($container);
        };

        $this->set($factory->getKey(), $callback);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key the key for the
     *
     * @throws UndefinedDependencyException when requested key is not set
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            $definition = $this->getDefinition($key);
            try {
                $this->data[$key] = $definition($this);
            } catch (ContainerExceptionInterface $e) {
                throw $e;
            } catch (\Exception $e) {
                throw new ContainerException(
                    "Error creating object with key '$key'",
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
     * Get the definition function
     *
     * @param string $key the definition key
     *
     * @throws UndefinedDependencyException when requested key is not set
     *
     * @return callable
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
