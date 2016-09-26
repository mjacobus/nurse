<?php

namespace Dummy;

use Nurse\Container;
use Nurse\Factory\FactoryInterface;

class MyDummyFactory implements FactoryInterface
{
    public function createService(Container $container)
    {
        $config = $container->get('someConfig');

        return new Connection($config);
    }

    public function getKey()
    {
        return 'theKey';
    }
}
