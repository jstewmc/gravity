<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;

/**
 * Anonymous function requires the file's namespace to localize identifiers.
 */
class Fx extends Service
{
    private $namespace;

    public function __construct(Id $id, callable $definition, Ns $namespace)
    {
        parent::__construct($id, $definition);

        $this->namespace = $namespace;
    }

    public function getDefinition(): callable
    {
        return parent::getDefinition();
    }

    public function getNamespace(): Ns
    {
        return $this->namespace;
    }
}
