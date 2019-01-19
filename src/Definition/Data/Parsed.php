<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIt
 */

namespace Jstewmc\Gravity\Definition\Data;

use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Definition
{
    public function __construct(Path $key)
    {
        parent::__construct($key);
    }

    public function getKey(): Path
    {
        return parent::getKey();
    }
}
