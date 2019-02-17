<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

class Read extends Requirement
{
    public function __construct(string $key, string $description, callable $validator)
    {
        parent::__construct($key, $description, $validator);
    }

    public function getKey(): string
    {
        return parent::getKey();
    }
}
