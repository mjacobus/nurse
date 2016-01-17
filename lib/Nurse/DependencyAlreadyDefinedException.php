<?php

namespace Nurse;

use Interop\Container\Exception\ContainerException;

/**
 * Nurse\DependencyAlreadyDefinedException
 */
class DependencyAlreadyDefinedException extends \InvalidArgumentException implements ContainerException
{
}
