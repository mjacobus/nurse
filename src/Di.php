<?php

namespace Nurse;

use Closure;

class Di
{
    use DependencyManagerAwareTrait;

    /**
     * @var Di
     */
    private static $instance;

    private function __construct()
    {
        $this->setDependencyManager(new Container());
    }

    /**
     * Get the storage container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->getDependencyManager();
    }

    /**
     * Defines the factory for the single instance objects that it should
     * create on demand
     *
     * @param string  $key     the id for the callable function
     * @param Closure $closure the factory for the given key
     *
     * @return Container
     */
    public static function set($key, Closure $closure)
    {
        return self::getInstance()->getContainer()->set($key, $closure);
    }

    /**
     * Get the requested data. If the data is a callable function, then
     * it only executes it the fist time and caches the result
     *
     * @param string $key the key for the
     *
     * @throws \InvalidArgumentException when requested key is not set
     *
     * @return mixed
     */
    public static function get($key)
    {
        return self::getInstance()->getContainer()->get($key);
    }

    /**
     * Get singleton instance
     *
     * @return Di
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
