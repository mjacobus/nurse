<?php

namespace Nurse;

use Interop\Container\Exception\ContainerException;

class DependencyAlreadyDefinedException extends \InvalidArgumentException implements ContainerException
{
}
