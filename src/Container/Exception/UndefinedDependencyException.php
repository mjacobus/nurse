<?php

namespace Nurse\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class UndefinedDependencyException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}
