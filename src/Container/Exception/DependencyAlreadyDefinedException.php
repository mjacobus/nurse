<?php

namespace Nurse\Container\Exception;

use Interop\Container\Exception\ContainerException;

class DependencyAlreadyDefinedException extends \InvalidArgumentException implements ContainerException
{
}
