<?php

namespace Dummy;

use Nurse\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class MyDummyFactory implements FactoryInterface
{
    public function createService(ContainerInterface $container)
    {
        $config = $container->get('someConfig');

        return new Connection($config);
    }

    public function getKey(): string
    {
        return 'theKey';
    }
}
