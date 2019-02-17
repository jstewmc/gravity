<?php

namespace Jstewmc\Gravity\Cache\Exception;

use Exception;
use Psr\SimpleCache\InvalidArgumentException as PSRInvalidArgumentException;
use Throwable;
use function sprintf;

class InvalidArgumentException extends Exception implements PSRInvalidArgumentException
{
    public function __construct(string $expectedType, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Given input is not of type %s', $expectedType), $code, $previous);
    }
}
