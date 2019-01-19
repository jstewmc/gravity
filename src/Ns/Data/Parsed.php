<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use Jstewmc\Gravity\Import\Data\Parsed as Import;
use Jstewmc\Gravity\Import\Exception\NotFound;
use Jstewmc\Gravity\Path\Data\Path;

class Parsed extends Ns
{
    public function getImport(string $name): Import
    {
        if (!$this->hasImport($name)) {
            throw new NotFound($name);
        }

        return $this->imports[$name];
    }

    public function getName(): ?Path
    {
        return parent::getName();
    }

    public function hasImport(string $name): bool
    {
        return array_key_exists($name, $this->imports);
    }

    public function setImports(array $imports)
    {
        $this->imports = [];

        // index by name for uniqueness and performance
        foreach ($imports as $import) {
            $this->imports[$import->getName()] = $import;
        }

        return $this;
    }

    public function setName(Path $name): self
    {
        $this->name = $name;

        return $this;
    }
}
