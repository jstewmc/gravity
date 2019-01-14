<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Data;

class Read extends Import
{
    public function __construct(string $path, string $name = null)
    {
        parent::__construct($path, $name);
    }

    public function getName(): ?string
    {
        return parent::getName();
    }

    public function getPath(): string
    {
        return parent::getPath();
    }
}
