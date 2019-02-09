<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Ns;
use Jstewmc\Gravity\Script\Data\Script;
use SplFileInfo;

/**
 * Uses Gravity's DSL to define a sript in a namespace.
 */
abstract class File extends SplFileInfo
{
    protected $namespace;

    protected $script;

    public function __construct(string $pathname, Ns $namespace, Script $script)
    {
        parent::__construct($pathname);

        $this->namespace = $namespace;
        $this->script    = $script;
    }

    public function getNamespace(): Ns
    {
        return $this->namespace;
    }

    public function getScript(): Script
    {
        return $this->script;
    }
}
