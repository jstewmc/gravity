<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Id\Data\Id;

class Resolved extends Deprecation
{
    public function __construct(Id $source, Id $replacement = null)
    {
        parent::__construct($source, $replacement);
    }

    public function getReplacement(): ?Id
    {
        return parent::getReplacement();
    }

    public function getSource(): Id
    {
        return parent::getSource();
    }
}
