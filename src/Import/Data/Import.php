<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Data;

use Jstewmc\Gravity\Path\Data\Path;

abstract class Import
{
    private $path;

    protected $name;

    public function __construct($path, $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }
}
