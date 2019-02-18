<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

use Jstewmc\Gravity\Id\Data\Id;

class Resolved extends Requirement
{
    public function __construct(Id $key, string $description, callable $validator)
    {
        parent::__construct($key, $description, $validator);
    }

    public function getKey(): Id
    {
        return parent::getKey();
    }
}
