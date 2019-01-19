<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

/**
 * Abbreviated "ns" because "namespace" is a reserved word. Since name and
 * imports are optional, a namespace may be empty.
 */
abstract class Ns
{
    protected $imports = [];

    protected $name;

    public function getImports(): array
    {
        return $this->imports;
    }

    public function getName()
    {
        return $this->name;
    }

    public function hasImports(): bool
    {
        return count($this->imports) > 0;
    }

    public function hasName(): bool
    {
        return $this->name !== null;
    }

    public function isEmpty(): bool
    {
        return ! $this->hasName() && ! $this->hasImports();
    }
}
