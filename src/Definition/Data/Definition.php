<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Data;

abstract class Definition
{
    protected $key;

    protected $value;

    public function __construct($key, $value = null)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
