<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Data;

use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Import
{
    public function __construct(Path $path, string $name)
    {
        parent::__construct($path, $name);
    }

    public function getName(): string
    {
        return parent::getName();
    }

    public function getPath(): Path
    {
        return parent::getPath();
    }
}
