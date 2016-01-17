<?php

namespace Nurse;

trait DependencyManagerAwareTrait
{
    /**
     * @var Container
     */
    private $dependencyManager;

    /**
     * @param Container $dependencyManager
     *
     * @return self
     */
    public function setDependencyManager(Container $dependencyManager)
    {
        $this->dependencyManager = $dependencyManager;

        return $this;
    }

    /**
     * @return Container
     */
    public function getDependencyManager()
    {
        if ($this->dependencyManager === null) {
            throw new \Exception('Dependency manager was not set');
        }

        return $this->dependencyManager;
    }
}
