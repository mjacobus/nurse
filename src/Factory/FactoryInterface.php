<?php

namespace Nurse\Factory;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    /**
     * @return mixed
     */
    public function createService(ContainerInterface $container);

    public function getKey(): string;
}
