<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

use Jstewmc\Gravity\Alias\Data\Read as Alias;
use Jstewmc\Gravity\Definition\Data\Read as Definition;
use Jstewmc\Gravity\Deprecation\Data\Read as Deprecation;

class Opened extends Script
{
    public function addAlias(Alias $alias): self
    {
        $this->aliases[] = $alias;

        return $this;
    }

    public function addDefinition(Definition $definition): self
    {
        $this->definitions[] = $definition;

        return $this;
    }

    public function addDeprecation(Deprecation $deprecation): self
    {
        $this->deprecations[] = $deprecation;

        return $this;
    }
}
