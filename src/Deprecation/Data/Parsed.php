<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\TypeMismatch;
use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Deprecation
{
    public function __construct(Path $source, Path $replacement = null)
    {
        if ($replacement !== null && !($replacement instanceof $source)) {
            throw new TypeMismatch($source, $replacement);
        }

        parent::__construct($source, $replacement);
    }

    public function getReplacement(): ?Path
    {
        return parent::getReplacement();
    }

    public function getSource(): Path
    {
        return parent::getSource();
    }
}
