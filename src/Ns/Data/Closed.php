<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

class Closed extends Ns
{
    public function getName(): ?string
    {
        return parent::getName();
    }

    public function setImports(array $imports): self
    {
        $this->imports = $imports;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
