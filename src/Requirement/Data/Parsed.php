<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Requirement
{
    public function __construct(Path $key, string $description, callable $validator)
    {
        parent::__construct($key, $description, $validator);
    }

    public function getKey(): Path
    {
        return parent::getKey();
    }
}
