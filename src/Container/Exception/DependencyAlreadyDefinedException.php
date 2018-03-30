<?php

namespace Nurse\Container\Exception;

use Psr\Container\ContainerExceptionInterface;

class DependencyAlreadyDefinedException extends \InvalidArgumentException implements ContainerExceptionInterface
{
}
