<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Script\Data\Interpreted as Script;

/**
 * Ready to be loaded into project: identifiers have been resolved and
 * definitions have been interpreted.
 */
class Ran extends File
{
    public function __construct(string $pathname, Ns $namespace, Script $script)
    {
        parent::__construct($pathname, $namespace, $script);
    }

    public function getAliases(): array
    {
        return $this->script->getAliases();
    }

    public function getDeprecations(): array
    {
        return $this->script->getDeprecations();
    }

    public function getServices(): array
    {
        return $this->script->getServices();
    }

    public function getSettings(): array
    {
        return $this->script->getSettings();
    }
}
