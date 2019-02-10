<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

class Circular extends Exception
{
    private $value;

    public function __construct(string $value)
    {
        $this->value   = $value;
        $this->message = "Circular deprecation for '$value'";
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
