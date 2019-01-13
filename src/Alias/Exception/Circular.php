<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

class Circular extends Exception
{
    private $value;

    public function __construct(string $value)
    {
        $this->value   = $value;
        $this->message = "Circular alias for '$value'";
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
