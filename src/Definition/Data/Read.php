<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIt
 */

namespace Jstewmc\Gravity\Definition\Data;

class Read extends Definition
{
    public function __construct(string $key, $value = null)
    {
        parent::__construct($key, $value);
    }

    public function getKey(): string
    {
        return parent::getKey();
    }
}
