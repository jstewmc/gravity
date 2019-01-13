<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\TypeMismatch;
use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Alias
{
    public function __construct(Path $source, Path $destination)
    {
        if (!($source instanceof $destination)) {
            throw new TypeMismatch($source, $destination);
        }

        parent::__construct($source, $destination);
    }

    public function getDestination(): Path
    {
        return parent::getDestination();
    }

    public function getSource(): Path
    {
        return parent::getSource();
    }
}
