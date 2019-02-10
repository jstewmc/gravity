<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

class Read extends Deprecation
{
    public function __construct(string $source, string $replacement = null)
    {
        parent::__construct($source, $replacement);
    }

    public function getReplacement(): ?string
    {
        return parent::getReplacement();
    }

    public function getSource(): string
    {
        return parent::getSource();
    }
}
