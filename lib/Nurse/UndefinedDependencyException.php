<?php

namespace Nurse;

use Interop\Container\Exception\NotFoundException;

class UndefinedDependencyException extends \InvalidArgumentException implements NotFoundException
{
}
