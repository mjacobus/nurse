<?php

namespace Nurse;

use Interop\Container\Exception\NotFoundException;

/**
 * Nurse\UndefinedDependencyException
 */
class UndefinedDependencyException extends \InvalidArgumentException implements NotFoundException
{
}
