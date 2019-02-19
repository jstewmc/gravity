<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Alias\Data\Read as Alias;
use Jstewmc\Gravity\Definition\Data\Read as Definition;
use Jstewmc\Gravity\Deprecation\Data\Read as Deprecation;
use Jstewmc\Gravity\Import\Data\Read as Import;
use Jstewmc\Gravity\Ns\Data\Opened as Ns;
use Jstewmc\Gravity\Requirement\Data\Read as Requirement;
use Jstewmc\Gravity\Script\Data\Opened as Script;


/**
 * Public methods constitute Gravity's file DSL.
 */
class Opened extends File
{
    public function __construct(string $pathname, Ns $namespace, Script $script)
    {
        parent::__construct($pathname, $namespace, $script);
    }

    public function alias(string $source, string $destination): self
    {
        $this->script->addAlias(new Alias($source, $destination));

        return $this;
    }

    public function deprecate(string $id, string $replacement = null): self
    {
        $this->script->addDeprecation(new Deprecation($id, $replacement));

        return $this;
    }

    public function namespace(string $namespace): self
    {
        $this->namespace->setName($namespace);

        return $this;
    }

    public function require(string $key, string $description, callable $validator): self
    {
        $this->script->addRequirement(new Requirement($key, $description, $validator));

        return $this;
    }

    public function set(string $key, $value = null): self
    {
        $this->script->addDefinition(new Definition($key, $value));

        return $this;
    }

    public function use(string $path, string $name = null): self
    {
        $this->namespace->addImport(new Import($path, $name));

        return $this;
    }
}
