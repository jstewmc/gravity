<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIt
 */

namespace Jstewmc\Gravity\Definition\Data;

class Read extends Definition
{
    public function __construct(string $key)
    {
        parent::__construct($key);
    }

    public function getKey(): string
    {
        return parent::getKey();
    }
}
