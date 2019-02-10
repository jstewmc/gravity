<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use Jstewmc\Gravity\Path\Data\Path;

class TypeMismatch extends Exception
{
    private $a;

    private $b;

    public function __construct(Path $a, Path $b)
    {
        $this->a = $a;
        $this->b = $b;
        $this->message = "Type mismatch between first (". get_class($a) .") "
            . "and second (". get_class($b) .") path";
    }

    public function getA(): Path
    {
        return $this->a;
    }

    public function getB(): Path
    {
        return $this->b;
    }
}
