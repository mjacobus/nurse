<?php

namespace Nurse\Container\Exception;

use Interop\Container\Exception\NotFoundException;

class UndefinedDependencyException extends \InvalidArgumentException implements NotFoundException
{
}
