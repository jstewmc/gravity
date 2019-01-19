<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use Jstewmc\Gravity\Import\Data\Read as Import;

class Opened extends Ns
{
    public function getName(): ?string
    {
        return parent::getName();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addImport(Import $import): self
    {
        $this->imports[] = $import;

        return $this;
    }
}
