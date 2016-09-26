<?php

namespace Nurse\Factory;

use Nurse\Container;

interface FactoryInterface
{
    /**
     * @param Container $container
     *
     * @return mixed
     */
    public function createService(Container $container);

    /**
     * @return string
     */
    public function getKey();
}
